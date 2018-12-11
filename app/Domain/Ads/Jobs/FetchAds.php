<?php namespace App\Domain\Ads\Jobs;

use App\Domain\Ads\Ad;
use App\Domain\Ads\Cabinet;
use App\Domain\Ads\Events\AdsFetched;
use App\Domain\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use VK\Client\VKApiClient;

class FetchAds implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Cabinet $cabinet */
    public $cabinet;

    /** @var User $user */
    public $user;

    /**
     * @param User $user
     * @param Cabinet $cabinet
     */
    public function __construct(User $user, Cabinet $cabinet)
    {
        $this->cabinet = $cabinet;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param VKApiClient $client
     * @return void
     * @throws \VK\Exceptions\VKApiException
     * @throws \VK\Exceptions\VKClientException
     */
    public function handle(VKApiClient $client)
    {
       try {
           $campaigns = $this->cabinet->campaigns;
           $campaignIds = $campaigns->pluck('api_campaign_id');

           $ads = $client->ads()->getAds($this->user->api_access_token, [
               'account_id' => $this->cabinet->api_account_id,
               'campaignIds' => $campaignIds
           ]);

           $oldAds = Ad::whereIn('api_campaign_id', $campaignIds)->get();

           $ads = collect($ads);
           $ads->map(function (array $ad) {
               $ad = [
                   'api_ad_id' => $ad['id'],
                   'api_campaign_id' => $ad['campaign_id'],
                   'name' => $ad['name'],
                   'age_restriction' => $ad['age_restriction'],
                   'ad_format' => $ad['ad_format'],
                   'cost_type' => $ad['cost_type'],
                   'cpm' => $ad['cpm'],
                   'impressions_limit' => $ad['impressions_limit'],
                   'approved' => $ad['approved'],
                   'ad_platform' => $ad['ad_platform'],
                   'start_time' => (int)$ad['start_time'] !== 0 ? $ad['start_time'] : null,
                   'stop_time' => (int)$ad['stop_time'] !== 0 ? $ad['stop_time'] : null,
                   'all_limit' => (int)$ad['all_limit']
               ];

               $ad = Ad::updateOrCreate([
                   'api_ad_id' => (int)$ad['api_ad_id']
               ], $ad);
               $ad->touch();
           });

           $this->deleteArchivedAds($oldAds->pluck('api_ad_id'), $ads->pluck('id'));

           event(new AdsFetched($this->user));
       } catch (\Exception $e) {
           $this->fail($e);
       }
    }

    protected function deleteArchivedAds($oldIds, $newIds)
    {
        $garbage = $oldIds->diff($newIds);
        Ad::whereIn('api_ad_id', $garbage)->delete();
    }
}

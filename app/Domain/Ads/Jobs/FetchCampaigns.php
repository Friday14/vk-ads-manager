<?php namespace App\Domain\Ads\Jobs;

use App\Domain\Ads\Cabinet;
use App\Domain\Ads\Campaign;
use App\Domain\Ads\Events\CampaignsFetched;
use App\Domain\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use VK\Client\VKApiClient;

class FetchCampaigns implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Cabinet $cabinet */
    public $cabinet;
    /** @var User $user */
    public $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param Cabinet $cabinet
     */
    public function __construct(User $user, Cabinet $cabinet)
    {
        $this->user = $user;
        $this->cabinet = $cabinet;
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
            $campaigns = $client->ads()->getCampaigns($this->user->api_access_token, [
                'account_id' => $this->cabinet->api_account_id
            ]);
            $campaigns = collect($campaigns);
            $campaigns->map(function (array $camp) {
                $campaign = [
                    'api_campaign_id' => $camp['id'],
                    'all_limit' => $camp['all_limit'],
                    'day_limit' => $camp['day_limit'],
                    'name' => $camp['name'],
                    'type' => $camp['type']
                ];
                $campaign = $this->cabinet->campaigns()->updateOrCreate([
                    'api_campaign_id' => $camp['id']
                ], $campaign);
                $campaign->touch();
            });
            event(new CampaignsFetched($this->user));
        } catch (\Exception $e) {
            $this->fail($e);
        }
    }
}

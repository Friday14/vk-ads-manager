<?php namespace App\Domain\Ads\Jobs;

use App\Domain\Ads\Cabinet;
use App\Domain\Ads\Campaign;
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

    /**
     * Create a new job instance.
     *
     * @param Cabinet $cabinet
     */
    public function __construct(Cabinet $cabinet)
    {
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
        $userOfCabinet = $this->cabinet->users()->whereNotNull('api_access_token')->first();

        $campaigns = $client->ads()->getCampaigns($userOfCabinet->api_access_token, [
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

        dd($campaigns);
    }
}

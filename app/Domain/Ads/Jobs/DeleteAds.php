<?php namespace App\Domain\Ads\Jobs;

use App\Domain\Ads\Ad;
use App\Domain\Ads\Cabinet;
use App\Domain\Ads\Campaign;
use App\Domain\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use VK\Client\VKApiClient;

class DeleteAds implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var string $token */
    public $token;
    /** @var Ad $ad */
    public $ad;

    public $cabinet;

    /**
     * Create a new job instance.
     *
     * @param string $token
     * @param Cabinet $cabinet
     * @param Ad $ad
     */
    public function __construct(string $token, Ad $ad)
    {
        $this->token = $token;
        $this->ad = $ad;
        $this->cabinet = $ad->campaign->cabinet;
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
            $this->ad->delete();
            $client->ads()->deleteAds($this->token, [
                'account_id' => $this->cabinet->api_account_id,
                'ids' => json_encode([$this->ad->api_ad_id])
            ]);
        } catch (\Exception $e) {
            $this->fail($e);
        }
    }
}

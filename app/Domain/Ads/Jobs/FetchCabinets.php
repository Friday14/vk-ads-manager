<?php namespace App\Domain\Ads\Jobs;

use App\Domain\Ads\Cabinet;
use App\Domain\Ads\Events\CabinetsFetched;
use App\Domain\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use VK\Client\VKApiClient;

class FetchCabinets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var User $user */
    public $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
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
            $apiCabinets = collect($client->ads()->getAccounts($this->user->api_access_token));

            $alreadySavedCabinets = Cabinet::whereIn('api_account_id', $apiCabinets->pluck('account_id'))
                ->get();

            // create new cabinets
            $syncCabinets = $apiCabinets->mapWithKeys(function (array $cab) use ($alreadySavedCabinets) {
                $accountId = $cab['account_id'];
                $cabinet = $alreadySavedCabinets->whereStrict('api_account_id', $accountId)->first();

                if (!$cabinet) {
                    $cabinet = new Cabinet();
                    $cabinet->api_account_id = $accountId;
                    $cabinet->name = $cab['account_name'];
                    $cabinet->type = $cab['account_type'];
                    $cabinet->status = $cab['account_status'];
                    $cabinet->save();
                }

                return [
                    $cabinet->id => [
                        'role' => $cab['access_role']
                    ]
                ];
            });
            $this->user->cabinets()->sync($syncCabinets);

            event(new CabinetsFetched($this->user));
        } catch (\Exception $e) {
            $this->fail($e);
        }
    }
}

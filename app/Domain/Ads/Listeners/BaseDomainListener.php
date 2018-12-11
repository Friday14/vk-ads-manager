<?php namespace App\Domain\Ads\Listeners;

use App\Domain\Ads\Events\AbstractFetchedEvent;
use App\Domain\Ads\Jobs\FetchAds;
use App\Domain\Ads\Jobs\FetchCampaigns;

class BaseDomainListener
{
    const REGISTERED = 'Registered';
    const CABINETS_FETCHED = 'CabinetsFetched';
    const CAMPAIGNS_FETCHED = 'CampaignsFetched';
    const ADS_FETCHED = 'AdsFetched';

    public function handle(AbstractFetchedEvent $event)
    {
        switch (class_basename($event)) {
            case self::CABINETS_FETCHED:
            {
                foreach ($event->user->cabinets as $cabinet) {
                    $fetchCampaignJob = new FetchCampaigns($event->user, $cabinet);
                    dispatch($fetchCampaignJob)->delay(10);
                }
                break;
            }

            case self::CAMPAIGNS_FETCHED:
            {
                foreach ($event->user->cabinets as $cabinet) {
                    $fetchAdsJob = new FetchAds($event->user, $cabinet);
                    dispatch($fetchAdsJob)->delay(10);
                }
                break;
            }

            case self::ADS_FETCHED:
            {
                // pass
            }
        }
    }
}
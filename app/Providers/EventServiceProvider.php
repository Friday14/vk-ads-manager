<?php

namespace App\Providers;

use App\Domain\Ads\Listeners\BaseDomainListener;
use App\Domain\Users\Listeners\NewUserListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\VKontakte\VKontakteExtendSocialite;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            NewUserListener::class
//            SendEmailVerificationNotification::class,
        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            VKontakteExtendSocialite::class
        ],
        /* ADS Events */
        \App\Domain\Ads\Events\CabinetsFetched::class => [
            BaseDomainListener::class
        ],
        \App\Domain\Ads\Events\CampaignsFetched::class => [
            BaseDomainListener::class
        ],
        \App\Domain\Ads\Events\AdsFetched::class => [
            BaseDomainListener::class
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

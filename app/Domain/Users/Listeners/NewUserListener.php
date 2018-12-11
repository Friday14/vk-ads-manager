<?php namespace App\Domain\Users\Listeners;

use App\Domain\Ads\Jobs\FetchCabinets;
use Illuminate\Auth\Events\Registered;

class NewUserListener
{
    public function handle(Registered $event)
    {
        $fetchCabinetsJob = new FetchCabinets($event->user);
        dispatch($fetchCabinetsJob);
    }
}
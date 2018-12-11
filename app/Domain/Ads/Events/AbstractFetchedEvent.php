<?php namespace App\Domain\Ads\Events;

use App\Domain\Users\User;
use Illuminate\Queue\SerializesModels;

abstract class AbstractFetchedEvent
{
    use SerializesModels;

    /**
     * @var User $user
     */
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

<?php

namespace App\Policies;

use App\Domain\Users\User;
use App\Domain\Ads\Ad;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the ad.
     *
     * @param  \App\Domain\Users\User  $user
     * @param  \App\Domain\Ads\Ad  $ad
     * @return mixed
     */
    public function view(User $user, Ad $ad)
    {
        //
    }

    /**
     * Determine whether the user can create ads.
     *
     * @param  \App\Domain\Users\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the ad.
     *
     * @param  \App\Domain\Users\User  $user
     * @param  \App\Domain\Ads\Ad  $ad
     * @return mixed
     */
    public function update(User $user, Ad $ad)
    {
        return $ad->hasUser($user);
    }

    /**
     * Determine whether the user can delete the ad.
     *
     * @param  \App\Domain\Users\User  $user
     * @param  \App\Domain\Ads\Ad  $ad
     * @return mixed
     */
    public function delete(User $user, Ad $ad)
    {
        return $ad->hasUser($user);
    }

    /**
     * Determine whether the user can restore the ad.
     *
     * @param  \App\Domain\Users\User  $user
     * @param  \App\Domain\Ads\Ad  $ad
     * @return mixed
     */
    public function restore(User $user, Ad $ad)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the ad.
     *
     * @param  \App\Domain\Users\User  $user
     * @param  \App\Domain\Ads\Ad  $ad
     * @return mixed
     */
    public function forceDelete(User $user, Ad $ad)
    {
        //
    }
}

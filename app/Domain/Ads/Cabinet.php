<?php

namespace App\Domain\Ads;

use App\Domain\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $api_account_id
 * @property int $name
 * @property int $status
 * @property int $type
 * @property Campaign[] $campaigns
 * @property User[] $users
 */
class Cabinet extends Model
{
    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

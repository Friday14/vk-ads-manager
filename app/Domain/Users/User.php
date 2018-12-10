<?php namespace App\Domain\Users;

use App\Domain\Ads\Cabinet;
use App\Domain\Ads\Campaign;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string $api_access_token
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'avatar', 'api_user_id', 'api_access_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    public function cabinets(): BelongsToMany
    {
        return $this->belongsToMany(Cabinet::class)->withPivot(['role']);
    }
}

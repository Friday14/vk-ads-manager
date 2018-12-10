<?php

namespace App\Domain\Ads;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $api_campaign_id
 * @property string $name
 * @property string $type
 * @property boolean $status
 * @property Carbon $start_time
 * @property Carbon $stop_time
 * @property integer $all_limit
 * @property integer $day_limit
 */
class Campaign extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'start_time',
        'stop_time'
    ];

    protected $guarded = ['id'];

    public function ads()
    {
        return $this->hasMany(Ad::class, 'api_campaign_id', 'api_campaign_id');
    }

    public function cabinet()
    {
        return $this->belongsTo(Cabinet::class);
    }
}

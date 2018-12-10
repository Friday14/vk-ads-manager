<?php

namespace App\Domain\Ads;

use App\Domain\Ads\Presenters\AdPresenterTrait;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use AdPresenterTrait;

    protected $guarded = ['id'];

    protected $dates = [
        'created_at',
        'updated_at',
        'start_time',
        'stop_time'
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'api_campaign_id', 'api_campaign_id');
    }

    public function isCostConversion(): bool
    {
        return $this->cost_type === 0;
    }

    public function hasUser($user)
    {
        return $user->cabinets()->whereHas('campaigns.ads', function ($query) {
                $query->where('id', $this->id);
            })->first() !== null;
    }
}

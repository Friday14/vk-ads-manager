<?php namespace App\Domain\Ads\Presenters;

trait AdPresenterTrait
{
    public function presentFormat(): string
    {
        return config('services.vkontakte.ads.formats')[$this->ad_format] ?? '-';
    }

    public function presentCostType(): string
    {
        return $this->cost_type === 1 ? 'Оплата за переходы': 'Оплата за показы';
    }

    public function presentApproved(): string
    {
        return config('services.vkontakte.ads.approved')[$this->approved] ?? '-';
    }

    public function presentCpc()
    {
        return $this->cpc / 100;
    }

    public function presentCpm()
    {
        return $this->cpm / 100;
    }
}
<?php namespace App\Http\Controllers;

use App\Domain\Ads\Campaign;

class CampaignController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Campaign $campaign)
    {
        $campaign->load('ads');
        return view('campaigns.show', compact('campaign'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Domain\Ads\Cabinet;
use Illuminate\Http\Request;
use Auth;

class CabinetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cabinets = Auth::user()->cabinets;

        return view('cabinets.index', compact('cabinets'));
    }

    public function show(Cabinet $cabinet)
    {
        $cabinet->load('campaigns.ads');
        return view('cabinets.show', compact('cabinet'));
    }

}

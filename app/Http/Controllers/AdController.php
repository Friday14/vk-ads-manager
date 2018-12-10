<?php

namespace App\Http\Controllers;

use App\Domain\Ads\Ad;
use App\Domain\Ads\Jobs\DeleteAds;
use App\Http\Requests\NoteRequest;
use Auth;

class AdController extends Controller
{

    public function edit(Ad $ad)
    {
        return view('ads.edit', compact('ad'));
    }

    public function update(NoteRequest $request, Ad $ad)
    {
        $this->authorize('update', $ad);

        $ad->note = $request->note;
        $ad->save();

        return redirect()->back()->with(['message' => 'Заметка добавлена']);
    }

    public function destroy(Ad $ad)
    {
        $this->authorize('delete', $ad);

        $this->dispatchNow(new DeleteAds(Auth::user()->api_access_token, $ad));
        return redirect()->back()->with(['message' => 'Объявление удалено']);
    }
}

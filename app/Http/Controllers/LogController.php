<?php

namespace App\Http\Controllers;

use App\Models\Log;

class LogController extends Controller
{
    public function index()
    {
        return view('logbook.index', [
            'logs' => Log::orderBy('created_at', 'desc')->paginate(25),
        ]);
    }

    public function show(Log $log)
    {
        return view('logbook.show', compact('log'));
    }

    public function favoriteOrUnfavorite(Log $log)
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user->favoriteLogs()->find($log)) {
            $user->favoriteLogs()->detach($log);
        } else {
            $user->favoriteLogs()->toggle($log);
        }

        return back();
    }
}

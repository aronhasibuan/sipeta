<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\LocationHistoryExport;
use Maatwebsite\Excel\Facades\Excel;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        Location::create([
            'user_id' => Auth::id(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'recorded_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    public function latest()
    {
        $locations = Location::with('user')
            ->whereHas('user', function ($query) {
                $query->where('is_tracking', true);
            })
            ->orderBy('recorded_at', 'desc')
            ->get()
            ->unique('user_id')
            ->values();

        return response()->json($locations);
    }

    public function start()
    {
        User::where('id', Auth::id())
            ->update(['is_tracking' => true]);

        return response()->json(['status' => 'started']);
    }

    public function stop()
    {
        User::where('id', Auth::id())
            ->update(['is_tracking' => false]);

        return response()->json(['status' => 'stopped']);
    }

    public function historyData(Request $request)
    {
        $locations = Location::where('user_id', $request->user_id)
            ->whereDate('recorded_at', $request->date)
            ->orderBy('recorded_at', 'asc')
            ->get();

        return response()->json($locations);
    }

    public function exportHistory(Request $request)
    {
        $user_id = $request->user_id;
        $date = $request->date;

        return Excel::download(
            new LocationHistoryExport($user_id, $date),
            'history_lokasi.xlsx'
        );
    }
}

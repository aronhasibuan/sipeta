<?php

namespace App\Exports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\FromCollection;

class LocationHistoryExport implements FromCollection
{
    protected $user_id;
    protected $date;

    public function __construct($user_id, $date)
    {
        $this->user_id = $user_id;
        $this->date = $date;
    }

    public function collection()
    {
        return Location::where('user_id', $this->user_id)
            ->whereDate('recorded_at', $this->date)
            ->select('latitude','longitude','recorded_at')
            ->orderBy('recorded_at','asc')
            ->get();
    }
}
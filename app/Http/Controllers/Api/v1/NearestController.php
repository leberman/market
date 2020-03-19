<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NearestController extends Controller
{
    public $latitude;
    public $longitude;

    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function coordinate()
    {
        try {
            return cache()->remember('nearest' . auth()->user()->id , Carbon::now()->addMinute(5), function () {
                return \App\Coordinate::select(DB::raw('*, ( 6367 * acos( cos( radians('.$this->latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$this->longitude.') ) + sin( radians('.$this->latitude.') ) * sin( radians( latitude ) ) ) ) AS distance'))
                    ->having('distance', '<', 25)
                    ->orderBy('distance')
                    ->get();
            });
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}

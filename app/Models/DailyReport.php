<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyReport extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'reporting_time',
        'title',
        'contents',
    ];

    public function fetchReport()
    {
        return $this->orderBy('reporting_time', 'desc')->get();
    }

    public function searchReport($searchMonth)
    {
        return $this->where('reporting_time', 'like', $searchMonth.'%')
                    ->orderBy('reporting_time', 'desc')
                    ->get();
    }

}

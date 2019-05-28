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
        'deleted_at'
    ];

    public function fetchReport()
    {
        return $this->orderBy('reporting_time', 'desc')->get();
    }

    public function searchReport($searchDay)
    {
        return $this->whereYear('reporting_time', $searchDay->year)->whereMonth('reporting_time', $searchDay->month)->orderBy('reporting_time', 'desc')->get();
    }

}

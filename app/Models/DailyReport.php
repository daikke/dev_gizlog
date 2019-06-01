<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyReport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'reporting_time',
        'title',
        'contents',
    ];

    protected $dates = [
        'reporting_time'
    ];

    public function fetchReport($searchReport)
    {
        $dailyReports = $this->orderBy('reporting_time', 'desc');
        if (isset($searchReport['search-month'])) {
            $dailyReports = $dailyReports->where('reporting_time', 'like', $searchReport['search-month'] . '%');
        }
        return $dailyReports->get();
    }
}

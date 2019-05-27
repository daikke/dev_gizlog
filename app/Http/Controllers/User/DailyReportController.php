<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyReport;
use App\Http\Requests\User\DailyReportRequest;
use Illuminate\Support\Carbon;

class DailyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $daily_report;

    public function __construct(DailyReport $daily_report)
    {
        $this->daily_report = $daily_report;
    }

    public function index(Request $request)
    {
        //
        $search_report = $request->all();
        if(!isset($search_report['search-month'])){
            $daily_reports = $this->daily_report->orderBy('reporting_time', 'desc')->get();
            return view('user.daily_report.index', compact('daily_reports'));
        }else{
            $search_day = new Carbon($search_report['search-month']);
            $daily_reports = $this->daily_report->whereYear('reporting_time', $search_day->year)->whereMonth('reporting_time', $search_day->month)->orderBy('reporting_time', 'desc')->get();
            return view('user.daily_report.index', compact('daily_reports'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('user.daily_report.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DailyReportRequest $request)
    {
        $validated = $request->validated();
        $this->daily_report->fill($validated)->save();
        return redirect()->to('daily_report');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $daily_reports = $this->daily_report->where('id', $id)->first();
        return view('user.daily_report.show', compact('daily_reports'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $daily_reports = $this->daily_report->where('id', $id)->first();
        return view('user.daily_report.edit', compact('daily_reports'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DailyReportRequest $request, $id)
    {
        //
        $validated = $request->validated();
        $this->daily_report->where('id', $id)->update($validated);
        return redirect()->to('daily_report');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $this->daily_report->where('id', $id)->delete();
        return redirect()->to('daily_report');
    }
}

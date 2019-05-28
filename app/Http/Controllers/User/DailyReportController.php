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
    protected $dailyReport;

    public function __construct(DailyReport $dailyReport)
    {
        $this->dailyReport = $dailyReport;
    }

    public function index(Request $request)
    {
        $searchReport = $request->all();
        if (isset($searchReport['search-month'])) {
            $searchDay = new Carbon($searchReport['search-month']);
            $dailyReports = $this->dailyReport->searchReport($searchDay);
            return view('user.daily_report.index', compact('dailyReports'));
        } else {
            $dailyReports = $this->dailyReport->fetchReport();
            return view('user.daily_report.index', compact('dailyReports'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $this->dailyReport->fill($validated)->save();
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
        $dailyReports = $this->dailyReport->find($id);
        return view('user.daily_report.show', compact('dailyReports'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dailyReports = $this->dailyReport->find($id);
        return view('user.daily_report.edit', compact('dailyReports'));
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
        $validated = $request->validated();
        $this->dailyReport->find($id)->fill($validated)->save();
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
        $this->dailyReport->find($id)->delete();
        return redirect()->to('daily_report');
    }
}

<?php

namespace Modules\Ad\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ad\Entities\AdReport;

class AdReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $reports = AdReport::with([
            'ad' => fn ($query) => $query->select(['id', 'estate_id', 'uuid']),
            'ad.estate' => fn ($query) => $query->select(['id', 'title'])
        ])->latest()->paginate(15);
        return view('ad::reports', compact('reports'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(AdReport $report)
    {
        $report->delete();
        return \success_delete('ad-report.index');
    }
}
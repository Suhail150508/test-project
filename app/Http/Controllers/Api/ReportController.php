<?php

namespace App\Http\Controllers\Api;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Interfaces\ReportInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;

class ReportController extends Controller
{
    protected $report;

    public function __construct(ReportInterface $report)
    {
        $this->report = $report;
    }

    public function index()
    {

    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request;
            $report = $this->report->create($data);
            DB::commit();

            return new ReportResource($report);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error', $e->getMessage()
            ]);
        }
    }

    public function show(Report $report)
    {

    }

    public function edit(Report $report)
    {

    }

    public function update(Request $request, Report $report)
    {

    }

    public function destroy(Report $report)
    {

    }
}

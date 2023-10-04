<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportTypeResource;
use App\Interfaces\ReportTypeInterface;
use App\Models\ReportType;
use Illuminate\Http\Request;

class ReportTypeController extends Controller
{
    protected $reportType;

    public function __construct(ReportTypeInterface $reportType)
    {
        $this->reportType = $reportType;
    }

    public function index()
    {
        $reportTypes = $this->reportType->get();

        return ReportTypeResource::collection($reportTypes);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show(ReportType $reportType)
    {

    }

    public function edit(ReportType $reportType)
    {

    }

    public function update(Request $request, ReportType $reportType)
    {

    }

    public function destroy(ReportType $reportType)
    {

    }
}

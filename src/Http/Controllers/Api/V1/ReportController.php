<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use Sty\Hutton\Models\Service;

use Sty\Hutton\Models\WeeklyWork;

use Sty\Hutton\Http\Service\ExportExcel;

class ReportController extends Controller
{

    public function builderJobsCompleted (Request $request)
    {
        $collection = Service::all();

        $filename = 'excel.xlsx';

        ExportExcel::export($collection,$filename);
    }
}

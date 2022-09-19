<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use Sty\Hutton\Models\Service;

use Sty\Hutton\Models\WeeklyWork;

use Sty\Hutton\Http\Service\ExportExcel;

use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    public function builderJobsCompleted (Request $request)
    {
        $data = Service::all();

        $rand = rand(10000000,9999999999);

        $filename = ('public/excel_exports/reports/report_'.$rand.'.xlsx');

        $view = 'Hutton::excel.builderJobsCompleted';

        $this->generateExcel($view,$data,$filename);

        return (asset('storage/excel_exports/reports/report_'.$rand.'.xlsx'));

//        return response()->download($filename);
    }

    public function generateExcel($view, $data, $filename)
    {
        return Excel::store(new ExportExcel($data, $view), ($filename));
    }
}

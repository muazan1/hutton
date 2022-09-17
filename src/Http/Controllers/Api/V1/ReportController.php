<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use Sty\Hutton\Models\Service;

use Sty\Hutton\Models\WeeklyWork;

use Sty\Hutton\Http\Service\ExportExcel;

use \Maatwebsite\Excel\ExcelServiceProvider;

class ReportController extends Controller
{

    public function builderJobsCompleted (Request $request)
    {
        $data = Service::all();

        $filename = 'excel.xlsx';

        $view = 'Hutton::excel.builderJobsCompleted';

        return $this->generateExcel($view,$data,$filename);
    }

    public function generateExcel($view, $data, $filename)
    {
        return Excel::store(new ExportExcel($data, $view), $filename);
    }
}

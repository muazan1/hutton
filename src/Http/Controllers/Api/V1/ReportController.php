<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use Sty\Hutton\Models\HsJob;
use Sty\Hutton\Models\Service;

use Sty\Hutton\Models\WeeklyWork;

use Sty\Hutton\Http\Service\ExportExcel;

use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    public function builderJobsCompleted(Request $request)
    {
        $data = HsJob::with(
            'plot.buildingType.site.builder',
            'service'
        )
            ->where('status', 'completed');

        if ($request->builder != 'all') {
            $data =
                $data->whereHas('plot.buildingType.site.builder', function ($query) use ($request) {
                    $query->where('id', $request->builders);
                });
        }

        $data = collect($data->get());

        $rand = rand(10000000, 9999999999);

        $filename = ('public/excel_exports/reports/report_' . $rand . '.xlsx');

        $view = 'Hutton::excel.builderJobsCompleted';

        $this->generateExcel($view, $data, $filename);

        return (asset('storage/excel_exports/reports/report_' . $rand . '.xlsx'));

    }

    public function builderRemainingJobs(Request $request)
    {

        $data = HsJob::with(
            'plot.buildingType.site.builder',
            'service'
        )
            ->where('status', '!=', 'completed');

        if ($request->builder_id != null) {
            $data =
                $data->whereHas('plot.buildingType.site.builder', function ($query) use ($request) {
                    $query->where('id', $request->builder_id);
                });
        }

        if ($request->site_id != null) {
            $data =
                $data->whereHas('plot.buildingType.site', function ($query) use ($request) {
                    $query->where('id', $request->site_id);
                });
        }

        $data = collect($data->get());

        $rand = rand(10000000, 9999999999);

        $filename = ('public/excel_exports/reports/report_' . $rand . '.xlsx');

        $view = 'Hutton::excel.builderRemainingJobs';

        $this->generateExcel($view, $data, $filename);

        return (asset('storage/excel_exports/reports/report_' . $rand . '.xlsx'));
    }

    public function joinerCompletedJobs(Request $request)
    {

        $data = HsJob::with(
            'plot.buildingType.site.builder',
            'service'
        )
            ->where('status', '!=', 'completed');

        if ($request->builder_id != null) {
            $data =
                $data->whereHas('plot.buildingType.site.builder', function ($query) use ($request) {
                    $query->where('id', $request->builder_id);
                });
        }

        if ($request->site_id != null) {
            $data =
                $data->whereHas('plot.buildingType.site', function ($query) use ($request) {
                    $query->where('id', $request->site_id);
                });
        }

        $data = collect($data->get());

        $rand = rand(10000000, 9999999999);

        $filename = ('public/excel_exports/reports/report_' . $rand . '.xlsx');

        $view = 'Hutton::excel.builderRemainingJobs';

        $this->generateExcel($view, $data, $filename);

        return (asset('storage/excel_exports/reports/report_' . $rand . '.xlsx'));

    }

    public function joinerWageSheet(Request $request)
    {

        $data = HsJob::with(
            'plot.buildingType.site.builder',
            'service'
        )
            ->where('status', '!=', 'completed');

        if ($request->builder_id != null) {
            $data =
                $data->whereHas('plot.buildingType.site.builder', function ($query) use ($request) {
                    $query->where('id', $request->builder_id);
                });
        }

        if ($request->site_id != null) {
            $data =
                $data->whereHas('plot.buildingType.site', function ($query) use ($request) {
                    $query->where('id', $request->site_id);
                });
        }

        $data = collect($data->get());

        $rand = rand(10000000, 9999999999);

        $filename = ('public/excel_exports/reports/report_' . $rand . '.xlsx');

        $view = 'Hutton::excel.builderRemainingJobs';

        $this->generateExcel($view, $data, $filename);

        return (asset('storage/excel_exports/reports/report_' . $rand . '.xlsx'));

    }

    public function builderInvoiceSheet(Request $request)
    {

        $data = HsJob::with(
            'plot.buildingType.site.builder',
            'service'
        )
            ->where('status', '!=', 'completed');

        if ($request->builder_id != null) {
            $data =
                $data->whereHas('plot.buildingType.site.builder', function ($query) use ($request) {
                    $query->where('id', $request->builder_id);
                });
        }

        if ($request->site_id != null) {
            $data =
                $data->whereHas('plot.buildingType.site', function ($query) use ($request) {
                    $query->where('id', $request->site_id);
                });
        }

        $data = collect($data->get());

        $rand = rand(10000000, 9999999999);

        $filename = ('public/excel_exports/reports/report_' . $rand . '.xlsx');

        $view = 'Hutton::excel.builderRemainingJobs';

        $this->generateExcel($view, $data, $filename);

        return (asset('storage/excel_exports/reports/report_' . $rand . '.xlsx'));

    }


    public function generateExcel($view, $data, $filename)
    {
        return Excel::store(new ExportExcel($data, $view), ($filename));
    }
}

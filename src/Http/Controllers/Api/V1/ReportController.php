<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use Sty\Hutton\Models\{DailyWork, PlotJob};

use Sty\Hutton\Http\Service\ExportExcel;

use Maatwebsite\Excel\Facades\Excel;

use App\Models\{User, Customer, Role};

class ReportController extends Controller
{
    public function builderJobsCompleted(Request $request)
    {
        $data = PlotJob::where('status', 'completed')->with(
            'plot.buildingType.site.builder',
            'service',
            'jobjoiner'
        );

        $builder = Customer::where('uuid', $request->builders)->first();

        if ($request->builders != 'all') {
            $data = $data->whereHas('plot.buildingType.site.builder', function (
                $query
            ) use ($builder) {
                $query->where('uuid', $builder->uuid);
            });
        }

        $data = collect($data->get());

        $rand = rand(10000000, 9999999999);

        $filename = 'public/excel_exports/reports/report_' . $rand . '.xlsx';

        $view = 'Hutton::excel.builderJobsCompleted';

        $this->generateExcel($view, $data, $filename);

        return asset('storage/excel_exports/reports/report_' . $rand . '.xlsx');
    }

    public function builderRemainingJobs(Request $request)
    {
        $data = PlotJob::with('plot.buildingType.site.builder', 'service')->where(
            'status',
            '!=',
            'completed'
        );

        if ($request->builder_slug != 'all') {
            $data = $data->whereHas('plot.buildingType.site.builder', function (
                $query
            ) use ($request) {
                $query->where('slug', $request->builder_slug);
            });
        }

        if ($request->site_id != 'all') {
            $data = $data->whereHas('plot.buildingType.site', function (
                $query
            ) use ($request) {
                $query->where('id', $request->site_id);
            });
        }

        $data = collect($data->get());

        $rand = rand(10000000, 9999999999);

        $filename = 'public/excel_exports/reports/report_' . $rand . '.xlsx';

        $view = 'Hutton::excel.builderRemainingJobs';

        $this->generateExcel($view, $data, $filename);

        return asset('storage/excel_exports/reports/report_' . $rand . '.xlsx');
    }

    public function joinerCompletedJobs(Request $request)
    {
        if ($request->joiner != 'all') {
            $joiner = User::where('uuid', $request->joiner)->first();

            $data = DailyWork::with(
                'weeklyWork.joiner',
                'plot.buildingType.site.builder',
                'service'
            )->whereHas('weeklyWork', function ($query) use ($joiner) {
                $query->where('user_id', $joiner->uuid);
            });
        } else {
            $data = DailyWork::with(
                'weeklyWork.joiner',
                'plot.buildingType.site.builder',
                'service'
            );
        }

        $data = $data->whereBetween('created_at', [
            $request->date_from,
            $request->date_to,
        ]);

        $data = collect($data->get());

        $rand = rand(10000000, 9999999999);

        $filename = 'public/excel_exports/reports/report_' . $rand . '.xlsx';

        $view = 'Hutton::excel.joinerCompletedJobs';

        $this->generateExcel($view, $data, $filename);

        return asset('storage/excel_exports/reports/report_' . $rand . '.xlsx');
    }

    public function joinerWageSheet(Request $request)
    {
        $joinerRole = Role::where('name', 'joiner')->first();

        $joiners = User::where('role_id', $joinerRole->id)->get();

        $data = DailyWork::with('weeklyWork.joiner')->whereBetween(
            'created_at',
            [$request->date_from, $request->date_to]
        );

        $data = collect($data->get())
            ->map(function ($item) {
                $item->joiner_name =
                    $item->weeklyWork->joiner->first_name .
                    ' ' .
                    $item->weeklyWork->joiner->last_name;

                $item->total_amount = $item->sum('amount');

                return [
                    'joiner_name' => $item->joiner_name,
                    'total_amount' => $item->total_amount,
                ];
            })
            ->unique();

        $rand = rand(10000000, 9999999999);

        $filename = 'public/excel_exports/reports/report_' . $rand . '.xlsx';

        $view = 'Hutton::excel.joinerWageSheet';

        $this->generateExcel($view, $data, $filename);

        return asset('storage/excel_exports/reports/report_' . $rand . '.xlsx');
    }

    public function builderInvoiceSheet(Request $request)
    {
        $data = PlotJob::with('plot.buildingType.site.builder', 'service')->where(
            'status',
            '!=',
            'completed'
        );

        if ($request->builder_id != null) {
            $data = $data->whereHas('plot.buildingType.site.builder', function (
                $query
            ) use ($request) {
                $query->where('id', $request->builder_id);
            });
        }

        if ($request->site_id != null) {
            $data = $data->whereHas('plot.buildingType.site', function (
                $query
            ) use ($request) {
                $query->where('id', $request->site_id);
            });
        }

        $data = collect($data->get());

        $rand = rand(10000000, 9999999999);

        $filename = 'public/excel_exports/reports/report_' . $rand . '.xlsx';

        $view = 'Hutton::excel.builderRemainingJobs';

        $this->generateExcel($view, $data, $filename);

        return asset('storage/excel_exports/reports/report_' . $rand . '.xlsx');
    }

    public function generateExcel($view, $data, $filename)
    {
        return Excel::store(new ExportExcel($data, $view), $filename);
    }

    public function ReportBySite(Request $request)
    {
        if ($request->sites != 'all') {
            $data = DailyWork::with(
                'weeklyWork.joiner',
                'plot.buildingType.site.builder',
                'service'
            )->whereHas('plot.buildingType.site', function ($query) use (
                $request
            ) {
                $query->where('id', $request->sites);
            });
        } else {
            $data = DailyWork::with(
                'weeklyWork.joiner',
                'plot.buildingType.site.builder',
                'service'
            );
        }

        $data = $data->whereBetween('created_at', [
            $request->date_from,
            $request->date_to,
        ]);

        //        return response()->json($data->get());

        $data = collect($data->get());

        $rand = rand(10000000, 9999999999);

        $filename = 'public/excel_exports/reports/report_' . $rand . '.xlsx';

        $view = 'Hutton::excel.ReportBySite';

        $this->generateExcel($view, $data, $filename);

        return asset('storage/excel_exports/reports/report_' . $rand . '.xlsx');
    }
}

<?php

namespace Sty\Hutton\Http\Service;

use App\Models\{User, Role};

use Carbon\Carbon;

use Barryvdh\DomPDF\Facade\Pdf;

class GeneratePDF
{
    public static function generateReport($data, $filename, $pdfname)
    {
        //        dd($data->dailyWork);
        $pdf = Pdf::loadView('Hutton::pdfs.joiner_weekly_report', [
            'data' => $data,
        ]);

        return $pdf->download($pdfname);
    }
}

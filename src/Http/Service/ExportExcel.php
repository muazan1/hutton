<?php

namespace Sty\Hutton\Http\Service;

use App\Models\User;

use App\Models\Role;

use Carbon\Carbon;

use Barryvdh\DomPDF\Facade\Pdf;

use Maatwebsite\Excel\Facades\Excel;

class ExportExcel
{
    public static function export($collection,$filename)
    {
        return Excel::download($collection, $filename);
    }

}

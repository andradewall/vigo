<?php

namespace App\Actions\Pdf;

use App\Models\{Contact, Rent};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class GeneratePdf
{
    /**
     * @param string $view
     * @param string $filename
     * @param array $data
     * @return Response
     */
    public static function run(
        string $view,
        string $filename,
        array $data,
    ): Response {
        $pdf = Pdf::loadView($view, $data);

        return $pdf->stream($filename);
    }
}

<?php

namespace App\Actions\Pdf;

use App\Models\{Contact, Rent};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class GenerateContractPdf
{
    public static function run(
        Rent $rent,
        Collection $products,
    ): Response {
        return GeneratePdf::run(
            'pdf.contract',
            'contrato.pdf',
            compact('rent', 'products')
        );
    }
}

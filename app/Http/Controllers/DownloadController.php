<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function downloadSampleCSV()
    {
        $filePath = public_path('formateresult.csv');

        return Response::download($filePath, 'formateresult.csv');
    }
}

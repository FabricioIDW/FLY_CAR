<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.reports')->only('reports');
    }

    public function reports()
    {
        return view('reports.reports');
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\AHPServices;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(AHPServices $ahpServices)
    {
        $alternativesScores = $ahpServices->calculate();    
        return view('pages.dashboard',[
            'alternativeScores' => $alternativesScores
        ]);
    }
}

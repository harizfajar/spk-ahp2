<?php

use App\Http\Controllers\AlternativeComparisonsController;
use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\CriteriaComparsions;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PerhitunganAHPController;
use App\Http\Controllers\ResidentController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('layouts.app');
// });
Route::get('/', [DashboardController::class,'index']);

Route::get('/resident', [ResidentController::class, 'index']);
Route::get('/resident', [PerhitunganAHPController::class, 'calculateAHP']);
Route::get('/resident/create', [ResidentController::class, 'create']);
Route::get('/resident/edit/{id}', [ResidentController::class, 'edit']);
Route::post('/resident/store', [ResidentController::class, 'store']);
Route::put('/resident/update/{id}', [ResidentController::class, 'update']);
Route::delete('/resident/{id}/delete', [ResidentController::class, 'delete']);

Route::get('/alternatives',[AlternativeController::class, 'index']);
Route::get('/alternatives/create',[AlternativeController::class,'create']);
Route::post('/alternatives/store',[AlternativeController::class,'store']);
Route::get('/alternatives/edit/{id}',[AlternativeController::class,'edit']);
Route::put('/alternatives/update/{id}',[AlternativeController::class,'update']);
Route::delete('/alternatives/delete/{id}' , [AlternativeController::class,'delete']);

Route::get('/criteria', [CriteriaController::class, 'index']);
Route::get('/criteria/create',[CriteriaController::class, 'create']);
Route::post('/criteria/store',[CriteriaController::class,'store']);
Route::get('/criteria/edit/{id}',[CriteriaController::class,'edit']);
Route::put('/criteria/update/{id}',[CriteriaController::class,'update'])->name('criteria.update');
Route::delete('/criteria/delete/{id}',[CriteriaController::class,'delete']);

Route::get('/criteria-comparisons', [CriteriaComparsions::class, 'index']);
Route::post('/criteria/compare', [CriteriaComparsions::class, 'compare'])->name('criteria.compare');
Route::get('/alternatives-comparisons',[AlternativeComparisonsController::class,'index']);
Route::get('/alternatives-comparisons/edit/{id}',[AlternativeComparisonsController::class,'edit']);
Route::put('/alternatives-comparisons/update/{id}',[AlternativeComparisonsController::class,'update']);
Route::get('/perhitungan-ahp',[PerhitunganAHPController::class,'calculateAHP']);
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PaymentController;

Route::prefix('payment')->group(function () {
   Route::post('pay',[PaymentController::class, 'store']);
});

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentRequest;
use App\Services\Payment\PaymentService;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public function store(PaymentRequest $request): JsonResponse
    {
        $paymentService = new PaymentService($request['payer'], $request['receiver'], $request['value']);
        $PaymentResult = $paymentService->makePayment();

        return response()->json(['message' => $PaymentResult['message']], $PaymentResult['status']);
    }
}

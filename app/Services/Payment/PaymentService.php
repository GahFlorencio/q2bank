<?php

namespace App\Services\Payment;

use App\Interfaces\Payment\StatusInterface;
use App\Models\Payments\Payment;
use App\Models\User\User;
use Illuminate\Support\Facades\Log;

class PaymentService implements StatusInterface
{
    private User $payer;
    private User $receiver;
    private float $value;

    public function __construct(int $payer_id, int $receiver_id, float $value)
    {
        $this->payer = User::find($payer_id);
        $this->receiver = User::find($receiver_id);
        $this->value = $value;
    }

    public function makePayment() : array
    {
        $isValidPayment =  $this->isValidPayment();

        if ($isValidPayment !== true) {
            return $isValidPayment;
        }

        try {
            $payment = Payment::create([
                'payer_id' => $this->payer->id,
                'receiver_id' => $this->receiver->id,
                'value' => $this->value,
                'status' => self::PEDDING,
            ]);
        }catch (\Exception $exception){
            Log::info('[Services][Payment][PaymentService][makePayment] Error: '.$exception);
            return ['message' => 'Failed to create Payment', 'status' => '500'];
        }

        $captured = $this->capture($payment);

        if (!$captured) {
            return ['message' => 'Payment gateway declined transaction or is down, please try again later', 'status' => '500'];
        }

        try{
            $this->debitValues();
            return ['message' => 'Payment made successfully', 'status' => '200'];
        }catch(\Exception $exception){
            Log::info('[Services][Payment][PaymentService][debitValues] Error: '.$exception);
            return ['message' => 'Failed to make transaction', 'status' => '500'];
        }

    }

    private function isValidPayment() : array | bool
    {
        if ($this->payer->is_company === false) {
            return ['message' => 'Payer can not be a company.', 'status' => '400'];
        }

        if ($this->receiver->is_company === true) {
            return ['message' => 'Receiver have to be a company.', 'status' => '400'];
        }

        if (!$this->hasBalance()) {
            return ['message' => 'Payer does not have the balance available.', 'status' => '400'];
        }

        return true;
    }

    private function hasBalance() : bool
    {
        return $this->payer->balance()->first()->value >= $this->value;
    }

    private function capture (Payment $payment) : bool
    {
      $captureStatus =  PaymentGateway::capture();

        $status = self::REFUSED;

        if($captureStatus) {
            $status =  self::PAID;
        }

        $payment->update(['status' => $status]);

        return $captureStatus;
    }

    private function debitValues() {

        $balance = $this->payer->balance()->first();
        $balance->update(['value'=> $balance->value - $this->value]);

        $balance = $this->receiver->balance()->first();
        $balance->update(['value'=> $balance->value + $this->value]);
    }
}

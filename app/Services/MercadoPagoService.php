<?php

namespace App\Services;

use JetBrains\PhpStorm\ArrayShape;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\SDK;

class MercadoPagoService
{
    public function __construct()
    {
        SDK::setAccessToken(config('services.mercado-pago.secret'));
    }

    #[ArrayShape(['status' => 'string', 'status_detail' => 'string', 'id' => 'int', 'date_approved' => "\DateTime", 'payer' => "\MercadoPago\Payer|object"])]
 public static function payment(array $data = []): array
 {
     $payment = new Payment();
     $payment->transaction_amount = (float) $data['transactionAmount'];
     $payment->token = $data['token'];
     $payment->description = $data['description'];
     $payment->installments = (int) $data['installments'];
     $payment->payment_method_id = $data['paymentMethodId'];
     $payment->issuer_id = (int) $data['issuer'];
     $payer = new Payer();
     $payer->email = $data['email'];
     $payer->identification = [
         'type' => $data['identificationType'],
         'number' => $data['identificationNumber'],
     ];
     $payment->payer = $payer;
     $payment->save();

     return [
         'status' => $payment->status,
         'status_detail' => $payment->status_detail,
         'id' => $payment->id,
         'date_approved' => $payment->date_approved,
         'payer' => $payment->payer,
     ];
 }

    #[ArrayShape(['status' => 'mixed', 'status_detail' => 'mixed', 'id' => 'mixed', 'date_approved' => 'mixed', 'payer' => 'mixed'])]
 public static function getPayment(string $id): array
 {
     $payment = Payment::find_by_id($id);

     return [
         'status' => $payment->status,
         'status_detail' => $payment->status_detail,
         'id' => $payment->id,
         'date_approved' => $payment->date_approved,
         'payer' => $payment->payer,
     ];
 }

    #[ArrayShape(['transaction_amount' => 'string', 'token' => 'string', 'description' => 'string', 'installments' => 'string', 'payment_method_id' => 'string', 'issuer_id' => 'string', 'email' => 'string', 'identificationType' => 'string', 'identificationNumber' => 'string'])]
 public static function Rules(): array
 {
     return [
         'transaction_amount' => 'required|numeric',
         'token' => 'required',
         'description' => 'required',
         'installments' => 'required|numeric',
         'payment_method_id' => 'required',
         'issuer_id' => 'required',
         'email' => 'required|email,exists:users,email',
         'identificationType' => 'required',
         'identificationNumber' => 'required',
     ];
 }
}

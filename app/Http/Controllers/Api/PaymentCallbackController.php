<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Midtrans\CallbackService;
use App\Http\Controllers\Controller;

class PaymentCallbackController extends Controller
{
    public function receive(Request $request)
    {
        $callback = new CallbackService;
        if ($callback->_isSignatureKeyVerified()) {
            $notification = $callback->getNotification();
            $order = $callback->getOrder();
            if ($callback->isSuccess()) {
                Transaksi::where('id', $order->id)->update([
                    'status_transaksi' => 'TERBAYAR',
                ]);
            }
            if ($callback->isExpire()) {
                Transaksi::find($order->id)->delete();
            }
            if ($callback->isCancelled()) {
                Transaksi::find($order->id)->delete();
            }

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Notification successfully processed',
                ]);
        } else {
            return response()
                ->json([
                    'error' => true,
                    'message' => 'Signature key not verified',
                ], 403);
        }
    }
}

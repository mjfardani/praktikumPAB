<?php

namespace App\Midtrans;

use stdClass;
use Carbon\Carbon;
use App\Models\Pesanan;
use App\Models\Transaksi;
use App\Midtrans\Midtrans;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class CallbackService extends Midtrans
{
    protected $notification;
    protected $order;
    protected $serverKey;
    public function __construct()
    {
        parent::__construct();
        $this->serverKey = env('MIDTRANS_SERVER_KEY');
        $this->_handleNotification();
    }
    public function _isSignatureKeyVerified()
    {
        // baris ini untuk mencoba lewat RESTER
        return true;
        // baris ini untuk mencoba lewat ngrok
        // return ($this->_createLocalSignatureKey()
        // == $this->notification->signature_key);
    }
    public function isSuccess()
    {
        $statusCode = $this->notification->status_code;
        $transactionStatus = $this->notification->transaction_status;
        $fraudStatus = false;
        if (trim($this->notification->fraud_status) != '') $fraudStatus = true;
        return ($statusCode == 200 && $fraudStatus &&
            ($transactionStatus == 'capture' ||
                $transactionStatus == 'settlement'));
    }
    public function isExpire()
    {
        return ($this->notification->transaction_status == 'expire');
    }
    public function isCancelled()
    {
        return ($this->notification->transaction_status == 'cancel');
    }
    public function getNotification()
    {
        return $this->notification;
    }
    public function getOrder()
    {
        return $this->order;
    }

    public function _createLocalSignatureKey()
    {
        $order_id = Carbon::parse($this->order->tanggal_order)
            ->format('Y-m-d') .
            str_pad($this->order->id, 4, '0', STR_PAD_LEFT);
        $statusCode = $this->notification->status_code;
        $grossAmount = $this->order->total_harga;
        $serverKey = $this->serverKey;
        $input = $orderId . $statusCode . $grossAmount . '.00' . $serverKey;
        $signature = openssl_digest($input, 'sha512');
        return $signature;
    }
    protected function _handleNotification()
    {
        $notification = new Notification();
        $pesanan_id = $notification->order_id;
        $id = substr($pesanan_id, -4);
        $transaksi = Transaksi::find($id);
        $this->notification = $notification;
        $this->order = $transaksi;
    }
}

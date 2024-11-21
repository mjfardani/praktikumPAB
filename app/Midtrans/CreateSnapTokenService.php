<?php

namespace App\Midtrans;

use Carbon\Carbon;
use Midtrans\Snap;
use App\Midtrans\Midtrans;

class CreateSnapTokenService extends Midtrans
{
    protected $transaksi;
    public function __construct($transaksi)
    {
        parent::__construct();
        $this->transaksi = $transaksi;
    }
    public function getSnapToken()
    {
        $order_id = Carbon::parse($this->transaksi->tanggal_order)
            ->format('Y-m-d') .
            str_pad($this->transaksi->id, 4, '0', STR_PAD_LEFT);
        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $this->transaksi->total_harga,
            ],
        ];
        $snapToken = Snap::getSnapToken($params);
        return $snapToken;
    }
}

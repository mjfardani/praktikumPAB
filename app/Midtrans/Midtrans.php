<?php

namespace App\Midtrans;

use Midtrans\Config;

class Midtrans
{
    protected $serverKey;
    protected $isProduction;
    protected $isSanitized;
    protected $is3ds;
    public function __construct()
    {
        $this->serverKey = env('MIDTRANS_SERVER_KEY');
        $this->isProduction = env('MIDTRANS_IS_PRODUCTION');
        $this->isSanitized = env('MIDTRANS_IS_SANITIZED');
        $this->is3ds = env('MIDTRANS_IS_3DS');
        $this->_configuredMidtrans();
    }
    public function _configuredMidtrans()
    {
        Config::$serverKey = $this->serverKey;
        Config::$isProduction = $this->isProduction;
        Config::$isSanitized = $this->isSanitized;
        Config::$is3ds = $this->is3ds;
    }
}

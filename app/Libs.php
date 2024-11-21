<?php

namespace App;

class Libs
{
    public static function hitung_berat_kirim($qty, $berat_satuan)
    {
        return ceil((($qty * $berat_satuan)) / 1000.0) * 1000;
    }
    public static function hitung_ongkos_kirim(
        $weight,
        $origin,
        $destination,
        $courier
    ) {
        $err_message = '';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                "key: " . env('RAJAONGKIR_KEY'),
                "Content-Type: application/x-www-form-urlencoded"
            ),
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.rajaongkir.com/starter/cost',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => http_build_query(
                [
                    'origin' => $origin,
                    'destination' => $destination,
                    'weight' => $weight,
                    'courier' => $courier
                ]
            ),
        ));
        $resp = curl_exec($curl);
        if (curl_errno($curl)) {

            $err_message = 'Error: "' . curl_error($curl) .
                '" - Code:' . curl_errno($curl);
        }
        curl_close($curl);
        if ($err_message == '') {
            $services = [];
            $json = json_decode($resp, TRUE);
            foreach ($json['rajaongkir']['results'][0]['costs'] as $cost) {
                $services[] = [
                    'service' => $cost['service'],
                    'ongkos_kirim' => $cost['cost'][0]['value'],
                    'waktu_kirim' => $cost['cost'][0]['etd']
                ];
            }
            return ['code' => '200', 'services' => $services];
        } else {
            return ['code' => '500', 'text' => $err_message];
        }
    }
}

<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait VolutiTrait
{
    public  static function authorization()
    {
        $data = array(
            "grant_type" => "client_credentials",
            "client_id" => env("CLIENT_ID"),
            "client_secret" => env("CLIENT_SECRET")
        );


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.pix.voluti.com.br/oauth/token");
        curl_setopt($ch, CURLOPT_PORT, 443);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSLCERT, storage_path('/certificates/VOLUTI201.crt'));
        curl_setopt($ch, CURLOPT_SSLKEY, storage_path('/certificates/VOLUTI201.key'));
        curl_setopt($ch, CURLOPT_CAINFO, storage_path('/certificates/VOLUTI201.cert'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        curl_close($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        // Decodifica o corpo da resposta JSON
        $responseData = json_decode($body, true);
        return $responseData["access_token"];
    }

    public function requestQrCode($amount)
    {
        $token = self::authorization();

        $data = array(
            "calendario" => array(
                "expiracao"=> 86400
            ),
            "valor" => array(
                "original"=>$amount
            ),

            "chave" => env("KEY")
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.pix.voluti.com.br/cob");
        curl_setopt($ch, CURLOPT_PORT, 443);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSLCERT, storage_path('/certificates/VOLUTI201.crt'));
        curl_setopt($ch, CURLOPT_SSLKEY, storage_path('/certificates/VOLUTI201.key'));
        curl_setopt($ch, CURLOPT_CAINFO, storage_path('/certificates/VOLUTI201.cert'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('authorization: Bearer '. $token,'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        curl_close($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        // Decodifica o corpo da resposta JSON
        $responseData = json_decode($body, true);
        return $responseData;
    }

    public function cashout() {}

    public function pixWebhook() {}
}

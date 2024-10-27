<?php

namespace App\Traits;

use App\Models\PixInModel;
use App\Models\PixOut;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\Return_;
use Ramsey\Uuid\Uuid;

trait VolutiTrait
{
    public  static function authorization()
    {

        if (!auth()->check()) {
            return response()->json(['error' => 'Não logado']);
        }

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
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        curl_close($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        // Decodifica o corpo da resposta JSON
        $responseData = json_decode($body, true);
        return  $responseData["access_token"];
    }



    public  static function authorizationCashout()
    {

        if (!auth()->check()) {
            return response()->json(['error' => 'Não logado']);
        }
        $data = array(
            "grantType" => "client_credentials",
            "clientId" => env("CLIENT_IDW"),
            "client_secret" => env("CLIENT_SECRETW")
        );



        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://accounts.voluti.com.br/api/v2/oauth/token");
        curl_setopt($ch, CURLOPT_PORT, 443);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSLCERT, storage_path('/certificates/VOLUTI202.crt'));
        curl_setopt($ch, CURLOPT_SSLKEY, storage_path('/certificates/VOLUTI202.key'));
        curl_setopt($ch, CURLOPT_CAINFO, storage_path('/certificates/VOLUTI202.cert'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        curl_close($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        // Decodifica o corpo da resposta JSON
        $responseData = json_decode($body, true);
        return $responseData["accessToken"];
    }

    public function requestQrCode($amount)
    {
        $token = self::authorization();

        $data = array(
            "calendario" => array(
                "expiracao" => 86400
            ),
            "valor" => array(
                "original" => $amount
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
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('authorization: Bearer ' . $token, 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        curl_close($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        // Decodifica o corpo da resposta JSON
        $responseData = json_decode($body, true);
        if (isset($responseData['pixCopiaECola'])) {
            $data = array(
                'amount' => $amount,
                'txtId' => $responseData['txid'],
                'user_id' => auth()->user()->id,
            );
            PixInModel::insert($data);
        }
        return $responseData;
    }

    public function cashout($amount, $pixKey)
    {

        if(auth()->user()->balance < $amount){
            return ['detail'=>'Saldo insuficiente'];
        }

        $token = self::authorizationCashout();
        $uuid = Uuid::uuid4();

        $withsrawalId =$uuid->toString();
        $data  = array(
            'id' =>     $withsrawalId ,
            "userId" => auth()->user()->id,
            "amount" => $amount

        );
        PixOut::insert($data);

        $data = array(
            "expiration" => 600,
            "payment" => array(
                "currency" => "BRL",
                "amount" => $amount
            ),
            "pixKey" => $pixKey
        );


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://accounts.voluti.com.br/api/v2/pix/payments/dict");
        curl_setopt($ch, CURLOPT_PORT, 443);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSLCERT, storage_path('/certificates/VOLUTI202.crt'));
        curl_setopt($ch, CURLOPT_SSLKEY, storage_path('/certificates/VOLUTI202.key'));
        curl_setopt($ch, CURLOPT_CAINFO, storage_path('/certificates/VOLUTI202.cert'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('authorization: Bearer ' . $token, 'Content-Type: application/json', 'x-idempotency-key:' .     $withsrawalId));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        curl_close($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);


        // Decodifica o corpo da resposta JSON


        // { ["endToEndId"]=> string(32) "E30385259202410261537191618a0373" ["eventDate"]=> string(29) "2024-10-26T15:37:19.161+00:00" ["status"]=> string(7) "PENDING" ["id"]=> int(72287107) ["payment"]=> array(2) { ["currency"]=> string(3) "BRL" ["amount"]=> int(1) } ["type"]=> string(6) "QUEUED" }
        $responseData = json_decode($body, true);
        if(isset($responseData['detail'])){
            return $responseData;
        }
        if ($responseData["status"] !== "REJECTED") {
            User::where("id", auth()->user()->id)->decrement('balance',$responseData['payment']['amount']); // descontar taxa tbm
            PixOut::where("id", $withsrawalId)->update(['endToEndId' => $responseData['endToEndId'], 'status' => 1]);
            return $responseData;
        } else {
            PixOut::where("id", $withsrawalId)->update(['endToEndId' => $responseData['endToEndId']]);
            
            return $responseData;
        }
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\PixInModel;
use App\Models\User;
use App\Traits\VolutiTrait;
use Illuminate\Http\Request;

class PixController extends Controller
{
    use VolutiTrait;
    public function gererateQrCode(Request $request)
    {
        $amount = $request->amount;
        $response = self::requestQrCode($amount);
        return response()->json($response);
    }

    public function pixCashout(Request $request)
    {
        $amount = $request->amount;
        $pixkey = $request->pixkey;
        $response = self::cashout($amount, $pixkey);
        return response()->json($response);
    }

    public function webhook(Request $request)
    {
        // {
        //     "data": {
        //         "id": 557737461,
        //         "txId": "dc5b1dd6c9462b807079b05bea4a1d",
        //         "pixKey": "417213cc-6513-4922-9842-5d5c18c2a971",
        //         "status": "LIQUIDATED",
        //         "payment": {
        //             "amount": "2.00",
        //             "currency": "BRL"
        //         },
        //         "refunds": [],
        //         "createdAt": "2024-10-26T19:29:16.018+00:00",
        //         "errorCode": null,
        //         "endToEndId": "E11275560202410261929IvFSvxqf4cs",
        //         "ticketData": {},
        //         "webhookType": "RECEIVE",
        //         "debtorAccount": {
        //             "ispb": "11275560",
        //             "name": "54.446.094 LUIS ARTHUR CRUZ SOUSA",
        //             "issuer": "0000",
        //             "number": "0000",
        //             "document": "54446094000156",
        //             "accountType": "TRAN"
        //         },
        //         "idempotencyKey": null,
        //         "creditDebitType": "CREDIT",
        //         "creditorAccount": {
        //             "ispb": "30385259",
        //             "name": "XNEXT SOLUTIONS EM SOFTWARE, FITECH LTDA",
        //             "issuer": "0000",
        //             "number": "0000",
        //             "document": "57752449000123",
        //             "accountType": "TRAN"
        //         },
        //         "localInstrument": "QRDN",
        //         "transactionType": "PIX",
        //         "remittanceInformation": null
        //     },
        //     "type": "RECEIVE"
        // }
        $data = $request->all();
        if($request->header('authorization') !== env('WEBHOOKKEY')){
            return response()->json(['error'=>'unauthorized'],403);
        }
        if ($data['type'] === 'RECEIVE') {
            $transaction = PixInModel::where('txtId', $data['data']['txId'])->first();
            if ($transaction->status === 0) {
                $amount = $transaction->amount - ($transaction->amount * 0.025); // subtrair a taxa
                User::where('id', $transaction->user_id)->increment('balance', $amount);
                PixInModel::where('txtId', $data['data']['txId'])->update(['status' => 1]);
                return response()->json(['success'=>'confirmado']);
            }else{
                return response()->json(['success'=>'ja confirmado']);
            }
        }
    }
}

<?php 
namespace App\Http\Controllers;

use App\Traits\VolutiTrait;
use Illuminate\Http\Request;

class PixController extends Controller {
    use VolutiTrait;
    public function gererateQrCode(Request $request){
        $amount = $request->amount;
        $response = self::requestQrCode($amount);
        return response()->json($response);

    }

    public function pixCashout(Request $request){

    }

    public function webhook(){

    }
}
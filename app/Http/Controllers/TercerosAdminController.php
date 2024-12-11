<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Events\UserAdminSendEmailCodeAccessEvent;

use App\Models\TercerosAdmin;


class TercerosAdminController extends Controller
{
    public function ValidarEmail (Request $FormData) {
        $EmailExiste = TercerosAdmin::where('email',  $FormData->email)->first();
        if (!$EmailExiste ) return ['message' =>'EmailNoExiste'];

        $AccessCode                 = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $EmailExiste['access_code'] = $AccessCode;
        $EmailExiste->save();
        UserAdminSendEmailCodeAccessEvent::dispatch($FormData->email, $AccessCode );
        return ['message' =>'AccessCodeEnviado'];
    }

}

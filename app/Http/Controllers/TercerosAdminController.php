<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\UserAdminSendEmailCodeAccessEvent;

use App\Models\TercerosAdmin;
use App\Helpers\DatesHelper as Fechas;


class TercerosAdminController extends Controller
{
    public function ValidarEmail (Request $FormData) {
        $EmailExiste = TercerosAdmin::where('email',  $FormData->email)->first();
        if (!$EmailExiste ) return ['message' =>'EmailNoExiste'];

        $AccessCode                 = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $EmailExiste['access_code'] = $AccessCode;
        $EmailExiste['expira']      = Fechas::AddHoras(2);

        $EmailExiste->save();
        UserAdminSendEmailCodeAccessEvent::dispatch($FormData->email, $AccessCode );
        return ['message' =>'AccessCodeEnviado'];
    }

    public function ValidarEmailAndAccessCode (Request $FormData) {
        $EmailExiste = TercerosAdmin::where('email',  $FormData->email)->first();
        if (!$EmailExiste )                                         return ['message' =>'EmailNoExiste'];
        if ($EmailExiste->access_code != $FormData->access_code)    return ['message' =>'AccessCodeIncorrecto'];
        if ($EmailExiste->expira < date('Y-m-d H:i:s'))             return ['message' =>'AccessCodeExpirado'];

        return ['message' =>'AccessCodeAndEmailOk'];
     }

}

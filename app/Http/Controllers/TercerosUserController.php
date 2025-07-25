<?php

namespace App\Http\Controllers;

use Str;
use Cache;

use Session;
use Carbon\Carbon;
use App\Models\TercerosUser;
use App\Models\Tercero as Clientes;
    use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\Events\UserPasswordResetEvent;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\TercerosUserLoginRequest;

class TercerosUserController extends Controller
{

    

    public function login(Request $FormData)
{
    $Cliente = Clientes::with([
        'TiposDocumento',
        'Municipios',
        'TiposPersonas',
        'Municipios.Departamentos',
    ])->where('email', $FormData->email)->first();

    if (!$Cliente) {
        return response()->json([
            'status' => 404,
            'message' => 'Email no registrado.',
            'data' => null
        ], 404);
    }

    $User = TercerosUser::where('email', $FormData->email)->first();

    if (!$User || !Hash::check($FormData->password, $User['password'])) {
        return response()->json([
            'status' => 401,
            'message' => Lang::get("validation.custom.UserLogin.credencials-error"),
            'data' => null
        ], 401);
    }

    Auth::login($User, true);
    $User->makeHidden(['password']);

    return response()->json([
        'status' => 200,
        'message' => 'Inicio de sesión exitoso.',
        'data' => [
            'cliente' => $Cliente,
            'user' => Auth::user()
        ]
    ]);
}





    // public function login ( Request $FormData ){
       
    //                   $Cliente = Clientes::with('TiposDocumento','Municipios','TiposPersonas', 'Municipios.Departamentos')->Where('email','=',$FormData->email)->first();
    //             return [
    //                 'cliente' => $Cliente,
    //                 'user'    => Auth::user()
    //             ];

    //      if (Auth::attempt( [
    //               'email'    => $FormData->email,
    //               'password' => $FormData->password,
    //               'autorizado' => 1 ],
    //                true ) ) {                               // true al final es para recordar sessión  
    //             $Cliente = Clientes::with('TiposDocumento','Municipios','TiposPersonas', 'Municipios.Departamentos')->Where('email','=',$FormData->email)->first();
    //             return [
    //                 'cliente' => $Cliente,
    //                 'user'    => Auth::user()
    //             ];
            
    //     }    
    //     $this->ErrorMessage ( Lang::get("validation.custom.UserLogin.credencials-error") );
    // }
  
      public function logout(){
         
        Session::flush();
        Cache::flush();
        Auth::logout();
    }


    public function resetPassword ( Request $FormData ){
        
        $User = TercerosUser::where('email', $FormData->email)->first();

        // if ( ! $User->autorizado || $User->inactivo ) {
        //     $this->ErrorMessage (  Lang::get("validation.custom.UserLogin.inactive-user") );
        // }  
        if ( !$User || $User->inactivo )   return response()->json('UsuarioNoEncontrado', 200); 
      

        $User->tmp_token        = Str::random(100);
        $User->tmp_token_expira = Carbon::now()->addMinute(15) ;
        $User->save();
        UserPasswordResetEvent::dispatch( $User->email, $User->tmp_token );
        return response()->json('Ok', 200);  
    }


    public function updatePassword ( TercerosUserLoginRequest $FormData ){
        $User = TercerosUser::where('tmp_token', $FormData->token)->first();
      
        $this->tokenValidate           ( $User  );
        $this->tokenExpirationValidate ( $User  );

        $User->password       = $FormData->password;
        $User->remember_token = '';
        $User->tmp_token      = '';
        $User->save();

       return response()->json($User, 200); 

    }

    private function tokenValidate ( $User ){
        if ( !$User) {
            throw ValidationException::withMessages( [
                'password' =>  [ 'El token de validación ha expirado o no ha sido validado. Debes iniciar el proceso nuevamente.'  ]
            ]);             
        }
    }

    private function tokenExpirationValidate ( $User ) {
        $Expiracion = $User->tmp_token_expira;
        $Diferencia = $Expiracion->diffInMinutes();
        if (  $Diferencia > 15 ) {
            throw ValidationException::withMessages( [
                'password' =>  [ 'El token de validación ha expirado o no ha sido validado. Debes iniciar el proceso nuevamente.'  ]
            ]);             
        }
    }

    private function ErrorMessage ( $ErrorTex ) {
        throw ValidationException::withMessages( [
            'email' =>  [$ErrorTex  ]
        ]);
    }

}

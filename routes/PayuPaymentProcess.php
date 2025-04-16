<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Productos\PaymentPayuConfirmationController;
 

Route::controller( PaymentPayuConfirmationController::class )
        ->prefix('ventas/online/payu/payment/')
        ->group ( function () {
                Route::post('confirmation'                        , 'PaymentConfirmation') ;
});


// https://api.fqesas.com/ventas/online/payu/payment/confirmation
//https://fqesas.com/shopping-cart/finish


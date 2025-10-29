<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body style="box-sizing: border-box;
         font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
         position: relative;
         -webkit-text-size-adjust: none;
         background-color: #ffffff;
         color: #718096;
         height: 100%;
         line-height: 1.4;
         margin: 0;
         padding: 0; width: 100% !important;" >

   <div style="box-sizing:border-box;
      font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe   UI Emoji','Segoe UI Symbol';
      background-color:#ffffff;     color:#718096;    height:100%;   line-height:1.4;   margin:0;      padding:0;     width:100%!important">
      <table width="100%" cellpadding="0" cellspacing="0"
         style="height:100%; box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#edf2f7;margin:0;padding:0;width:100%">
         <tbody>
            <tr>
               <td  style="box-sizing:border-box;
                  font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'">
                  <table width="100%" cellpadding="0" cellspacing="0" style="box-sizing:border-box;
                     font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,
                     Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';
                     margin:0;padding:0;width:100%">
                     <tr>
                        @include('mails.partials.TituloEmpresa')
                     </tr>
                     <tr>
                        <td width="100%" cellpadding="0" cellspacing="0" style="box-sizing:border-box;
                           font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#edf2f7;border-bottom:1px solid #edf2f7;border-top:1px solid #edf2f7;margin:0;padding:0;width:100%">
                           <table align="center"  width="570" cellpadding="0" cellspacing="0" style="box-sizing:border-box;
                              font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';background-color:#ffffff;border-color:#e8e5ef;border-radius:2px;border-width:1px;margin:0 auto;padding:0;width:570px">
                              <tbody>
                                 <tr>
                                    <td style="box-sizing:border-box;
                                       font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';max-width:100vw;padding:32px">

                                       <h1 style="box-sizing:border-box;
                                          font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color   Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#3d4852;font-size:18px;font-weight:bold;margin-top:0;text-align:left">
                                          ¡Confirmación de Pago Recibido!
                                       </h1>

                                       <div style="box-sizing:border-box;
                                             font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe   UI Emoji','Segoe UI Symbol'">

                                          <p>Estimado equipo,</p>

                                          <p>Se ha recibido el pago correspondiente al siguiente pedido:</p>

                                          <div style="background-color:#f7fafc; padding:20px; border-radius:5px; margin:20px 0;">
                                             <h3 style="margin-top:0; color:#2d3748;">Detalles del Pedido</h3>
                                             <p><strong>Número de Pedido:</strong> #{{ $pedido->idpddo }}</p>
                                             <p><strong>Cliente:</strong> {{ $pedido->Cliente ? $pedido->Cliente->nombre : 'N/A' }}</p>
                                             <p><strong>Email del Comprador:</strong> {{ $emailComprador }}</p>
                                             <p><strong>Fecha del Pedido:</strong> {{ $pedido->fcha_pddo ? $pedido->fcha_pddo->format('d/m/Y H:i') : 'N/A' }}</p>
                                             <p><strong>Referencia PayU:</strong> {{ $pedido->payu_reference }}</p>
                                             <p><strong>ID Transacción PayU:</strong> {{ $pedido->payu_transaction_id }}</p>
                                             <p><strong>Fecha Transacción:</strong> {{ $pedido->payu_transaction_date }}</p>
                                             <p><strong>Valor Total:</strong> ${{ number_format($pedido->vr_total, 0, ',', '.') }}</p>
                                             <p><strong>Estado del Pago:</strong> <span style="color:#38a169; font-weight:bold;">CONFIRMADO</span></p>
                                          </div>

                                          <div style="background-color:#e6fffa; padding:15px; border-radius:5px; margin:20px 0; border-left:4px solid #38a169;">
                                             <p style="margin:0;"><strong>✅ Pago procesado exitosamente</strong></p>
                                             <p style="margin:5px 0 0 0;">El pedido está listo para continuar con el proceso de preparación y envío.</p>
                                          </div>

                                          @if($pedido->PedidoDt && $pedido->PedidoDt->count() > 0)
                                          <h3 style="color:#2d3748;">Productos del Pedido</h3>
                                          <table style="width:100%; border-collapse:collapse; margin:10px 0;">
                                             <thead>
                                                <tr style="background-color:#edf2f7;">
                                                   <th style="border:1px solid #e2e8f0; padding:8px; text-align:left;">Producto</th>
                                                   <th style="border:1px solid #e2e8f0; padding:8px; text-align:center;">Cantidad</th>
                                                   <th style="border:1px solid #e2e8f0; padding:8px; text-align:right;">Valor</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                @foreach($pedido->PedidoDt as $detalle)
                                                <tr>
                                                   <td style="border:1px solid #e2e8f0; padding:8px;">
                                                      {{ $detalle->Productos ? $detalle->Productos->nomproducto : 'Producto #' . $detalle->idproducto }}
                                                   </td>
                                                   <td style="border:1px solid #e2e8f0; padding:8px; text-align:center;">
                                                      {{ $detalle->cantidad }}
                                                   </td>
                                                   <td style="border:1px solid #e2e8f0; padding:8px; text-align:right;">
                                                      ${{ number_format($detalle->vr_total, 0, ',', '.') }}
                                                   </td>
                                                </tr>
                                                @endforeach
                                             </tbody>
                                          </table>
                                          @endif

                                          <p>Este es un mensaje automático generado por el sistema de confirmación de pagos PayU.</p>

                                          <p>Atentamente,<br>
                                          Sistema de Ventas Online FQE S.A.S.</p>

                                       </div>

                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        @include('mails.invoices._Footer')
                     </tr>
         </tbody>
      </table>
      </td>
   </tr>
</tbody>
</table>
</div>

</body>
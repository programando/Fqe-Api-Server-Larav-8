<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="utf-8">
  <meta name="x-apple-disable-message-reformatting">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
  <!--[if mso]>
    <xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml>
    <style>
      td,th,div,p,a,h1,h2,h4,h4,h5,h6 {font-family: "Segoe UI", sans-serif; mso-line-height-rule: exactly;}
    </style>
  <![endif]-->
    <title>Cripack - Despachos TCC</title>
</head>
<body style="font-size: 12px; margin: 0; padding: 0; width: 100%; word-break: break-word; -webkit-font-smoothing: antialiased; background-color: #fff;">
 
  <div role="article"  lang="en">
    <header style="display: flex; margin: 0 40px;">
      <div style="font-size: 12px;">
       
        
        <h3 style="margin-top: 20px; margin-bottom: 20px;margin: 0;"> Informe eventos en facturas de venta</h3>
        
        <br><br>
      </div>
    </header> 
    <aside style="margin: 0 40px; margin-top: 50px;">
      <div>
        <h3 style="font-weight: 500;">A continuación se relacionan las facturas de venta generadas junto con los eventos asociados al día de hoy</h3>
      </div>
      <br><br>
       <table   width="100%">
      <thead  style="text-align: center; color: #fff; background-color: #272C6B; height:25px;">
        <tr>
          <th>#</th>
          <th>Fecha</th>
          <th>Factura</th>
          <th>Cliente</th>
          <th>Acuse recibo</th>
          <th>Recibo bien</th>
          <th>Aceptación expresa</th>
          <th>Rechazó factura</th>
        </tr>
      </thead>
      <tbody>
             {!! $BodyTable !!}
      </tbody>
      </table>

 
    </aside>

  </div>
  <footer>
    <br><br><br><br><br><br>
    Correo generado de manera autómatica por el sistema de información
  </footer>
</body>
</html>
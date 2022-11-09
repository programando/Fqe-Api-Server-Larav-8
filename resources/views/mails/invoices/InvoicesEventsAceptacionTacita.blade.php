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
    <title>FQE - SAS - Eventos facturas</title>
</head>
<body style="font-size: 11px; margin: 0; padding: 0; width: 100%; word-break: break-word; -webkit-font-smoothing: antialiased; background-color: #fff;">
 
  <div role="article"  lang="en">
    <header style="display: flex; margin: 0 40px;">
      <div style="font-size: 12px;">
       
        <br>
        <h3 style="margin-top: 20px; margin-bottom: 20px;margin: 0;"> Aceptación tácita factura de venta</h3>
        
        <br><br>
      </div>
    </header> 
    <aside style="width: 40% ; margin: 0 40px; margin-top: 50px;">
      <div>
        <h3 style="font-weight: 500;">Nos permitimos informar que se ha emitido evento: <br> <br><strong> 034 - ACEPTACIÓN TÁCITA</strong> a 
        la factura de venta número: <strong> {{$Prefijo.$NumeroFactura }} </strong> por cuanto ha cumplido el tiempo establecido por la DIAN sin que hayamos recibido confirmación de aceptación expresa.
        <br><br>
        Puede consultar detalles de la factura en el siguiente enlace :
           <a href="{{ $UrlConsultaEvento }}"  target="_blank"  >    
           Factura de venta en la DIAN
           </a>
            <br>
           
           </a>

      </h3>
      </div>

      <br><br>

 
    </aside>

  </div>
  Cordialmente, <br><br>
  <footer style="font-size: 14px;">
  
      <strong>
        Departamento de contabilidad <br>
        Formulaciones Químicas Especializadas FQE-SAS
      </strong>

    <br><br><br>
    <div style="font-size: 9px;"> Correo generado de manera autómatica por nuestro sistema de información.</div>
  </footer>
</body>
</html>
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceSendToCustomerMail;
use Illuminate\Support\Facades\Storage;

class TestMailController extends Controller
{
    public function sendTest()
    {
        $targetEmail = 'test-n11rfy1ek@srv1.mail-tester.com';
        
        // Datos de prueba simulando una factura
        $datosFactura = [
            'prfjo_dcmnto' => 'TEST',
            'nro_dcmnto' => '9999',
            'document_number' => 'TEST-9999',
            'uuid' => '0000-TEST-UUID-0000',
            'customer' => ['name' => 'MAIL TESTER USER'],
            'emails' => collect([ (object)['email' => $targetEmail] ])
        ];

        // Crear archivos temporales para el adjunto (simulando Factura XML/PDF)
        $tempPath = storage_path('app/public/test_invoice.zip');
        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }
        file_put_contents($tempPath, 'Contenido de prueba para el archivo ZIP');

        $subject = config('company.NIT').";".config('company.EMPRESA').";TEST9999;01;".config('company.EMPRESA');

        try {
            Mail::to($targetEmail)->send(new InvoiceSendToCustomerMail(
                $datosFactura,
                'test_invoice.pdf',
                'test_invoice.xml',
                'path/to/pdf',
                'path/to/xml',
                $subject,
                $tempPath,
                'test_invoice.zip'
            ));

            return response()->json([
                'status' => 'success',
                'message' => 'Correo enviado a ' . $targetEmail,
                'subject' => $subject
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

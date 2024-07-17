<?php

// InvoiceController.php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use App\Models\Indent;

class InvoiceController extends Controller
{
    public function generateInvoice($id)
    {
        // Fetch data needed for the invoice
        $indent = Indent::findOrFail($id);

        // Pass data to the view
        $data = [
            'indent' => $indent,
        ];

        // Render the invoice HTML
        $html = View::make('truck.completetrips', $data)->render();

        // Create PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF
        $dompdf->render();

        // Output the generated PDF (force download)
        return $dompdf->stream('invoice.pdf');
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Prescription;
use Spatie\Browsershot\Browsershot;

class PrintController extends Controller
{
    public function downloadPDF(Prescription $prescription)
    {
        $path = public_path('images/FILARCA.png');

        // Step 2: Get the image type
        $type = pathinfo($path, PATHINFO_EXTENSION);

        // Step 3: Get the image content
        $data = file_get_contents($path);

        // Step 4: Create the Base64 encoded string
        $src = 'data:image/' . $type . ';base64,' . base64_encode($data);

        // Step 5: Render the Blade view to HTML and pass the Base64 image string
        $html = view('admin.prescription.print_preview', ['imageSrc' => $src, 'prescription' => $prescription])->render();

        // Step 6: Generate the PDF from the rendered HTML
        $currentDate = Carbon::now()->format('Y-m-d');
        $pdfPath = public_path($currentDate . ' - Prescription.pdf');
        Browsershot::html($html)
                ->margins(15.4, 15.4, 15.4, 15.4)
                ->showBackground()
                ->save($pdfPath);

        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }

    public function previewPDF(Prescription $prescription)
    {
        $path = public_path('images/FILARCA.png');

        // Step 2: Get the image type
        $type = pathinfo($path, PATHINFO_EXTENSION);

        // Step 3: Get the image content
        $data = file_get_contents($path);

        // Step 4: Create the Base64 encoded string
        $src = 'data:image/' . $type . ';base64,' . base64_encode($data);

        // Step 5: Render the Blade view to HTML and pass the Base64 image string
        $html = view('admin.prescription.print_preview', ['imageSrc' => $src, 'prescription' => $prescription])->render();

        // Step 6: Generate the PDF from the rendered HTML
        $currentDate = Carbon::now()->format('Y-m-d');
        $pdfPath = public_path($currentDate . ' - Prescription.pdf');

        Browsershot::html($html)
                ->margins(15.4, 15.4, 15.4, 15.4)
                ->showBackground()
                ->save($pdfPath);

        // Step 7: Return the generated PDF as a response to be viewed inline in the browser
        return response()->file($pdfPath, [
            'Content-Type' => 'application/pdf',
            "Content-Disposition' => 'inline; filename='$pdfPath'",
        ]);
    }
}

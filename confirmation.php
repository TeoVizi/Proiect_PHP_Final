<?php
// Include the FPDF library
require('fpdf.php');

// Initialize FPDF and create a custom PDF class
class PDF extends FPDF {
    function AddInvoiceContent($movieTitle, $paymentAmount) {
        // Add an invoice header
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Invoice', 0, 1, 'C');
        $this->Ln(10);

        // Invoice details
        $this->SetFont('Arial', '', 12);
        $this->Cell(60, 10, 'Movie:', 0, 0);
        $this->Cell(0, 10, $movieTitle, 0, 1);

        $this->Cell(60, 10, 'Amount:', 0, 0);
        $this->Cell(0, 10, $paymentAmount . ' lei', 0, 1);
    }

    function GenerateInvoice($movieTitle, $paymentAmount) {
        // Add a page
        $this->AddPage();

        // Add invoice content
        $this->AddInvoiceContent($movieTitle, $paymentAmount);
    }
}

// Create an instance of the PDF class
$pdf = new PDF();

// Retrieve movie title and payment amount from the form or URL parameters
$movieTitle = $_GET['movie_title']; // Replace with the correct method of data retrieval
$paymentAmount = $_GET['payment_amount']; // Replace with the correct method of data retrieval
// Generate the invoice with the specified data
$pdf->GenerateInvoice($movieTitle, $paymentAmount);

// Set headers for downloading the PDF
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="invoice.pdf"');

// Output the generated PDF
$pdf->Output();
?>

<?php
require 'vendor/autoload.php'; // Include a library like FPDF or TCPDF
require 'db.php'; // Your database connection

use FPDF\FPDF; 

// Fetch call details
$callCode = $_GET['call_code'];
$result = Databases::search("SELECT * FROM `calls` WHERE `call_code` = '$callCode'");

if ($result->num_rows > 0) {
    $callData = $result->fetch_assoc();

    // Fetch additional details (like system type)
    $systemTypeResult = Databases::search("SELECT * FROM `system_type` WHERE `type_id` = '{$callData['system_id']}'");
    $systemType = $systemTypeResult->fetch_assoc();

    // Generate PDF
    $pdf = new FPDF();  
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    $pdf->Cell(190, 10, 'Project Details', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, 'Name:', 0, 0);
    $pdf->Cell(140, 10, $callData['name'], 0, 1);

    $pdf->Cell(50, 10, 'Date:', 0, 0);
    $pdf->Cell(140, 10, $callData['date_time'], 0, 1);

    $pdf->Cell(50, 10, 'System Type:', 0, 0);
    $pdf->Cell(140, 10, $systemType['type_name'], 0, 1);

    $pdf->Cell(50, 10, 'Description:', 0, 0);
    $pdf->MultiCell(140, 10, $callData['description'], 0, 1);

    // Output the PDF
    $pdf->Output();
} else {
    echo "Invalid call code.";
}
?>

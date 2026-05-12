<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'fpdf/fpdf.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['first_name'];
    $lastName  = $_POST['last_name'];
    $contact   = $_POST['contact'];
    $address   = $_POST['address'];
    $cartData  = json_decode($_POST['cart_data'], true);

    // 1. Generate PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, "Order Confirmation - The Nation's Bookstore", 0, 1, 'C');
    $pdf->Ln(10);
    
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, "Customer: $firstName $lastName", 0, 1);
    $pdf->Cell(0, 10, "Address: $address", 0, 1);
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(100, 10, "Book Title", 1);
    $pdf->Cell(30, 10, "Qty", 1);
    $pdf->Cell(40, 10, "Price", 1);
    $pdf->Ln();

    $total = 0;
    foreach ($cartData as $item) {
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(100, 10, $item['book']['title'], 1);
        $pdf->Cell(30, 10, $item['qty'], 1);
        $price = $item['book']['price'] * $item['qty'];
        $pdf->Cell(40, 10, "PHP " . number_format($price, 2), 1);
        $pdf->Ln();
        $total += $price;
    }

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(130, 10, "Total Amount", 1);
    $pdf->Cell(40, 10, "PHP " . number_format($total, 2), 1);

    $pdfDoc = $pdf->Output('S'); // Output as string for attachment

    // 2. Send Email
    $mail = new PHPMailer(true);
    try {
        // SMTP Settings (Use your email provider's settings)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'thenationsbookstore@gmail.com';
        $mail->Password   = 'wtdt ywpp uwup shnz'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('thenationsbookstore@gmail.com', 'The Nation\'s Bookstore');
        $mail->addAddress('customer-email@example.com'); // You may want to add an email field to your form

        $mail->isHTML(true);
        $mail->Subject = 'Your Order Confirmation';
        $mail->Body    = "Hello $firstName, thank you for your order! Please find your receipt attached.";
        
        $mail->addStringAttachment($pdfDoc, 'receipt.pdf'); // Attach PDF

        $mail->send();
        echo json_encode(["status" => "success"]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $mail->ErrorInfo]);
    }
}
?>
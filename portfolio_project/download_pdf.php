<?php
require('fpdf/fpdf.php');

// Database connection
include 'config/db.php'; 

session_start();
$user_id = $_SESSION['user_id'];

// Fetch user data
$sql = "SELECT * FROM portfolios WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$stmt->close();
$conn->close();

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();

// Colors and Fonts
$header_bg = [33, 53, 71]; // Dark blue
$section_bg = [54, 115, 177]; // Light blue
$font_color = [0, 0, 0]; // Black

// Header with Background
$pdf->SetFillColor($header_bg[0], $header_bg[1], $header_bg[2]);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 15, "Dynamic Portfolio", 0, 1, 'C', true);

// Profile Picture
if (!empty($data['photo']) && file_exists($data['photo'])) {
    $pdf->Image($data['photo'], 160, 20, 30, 30);
}

// Reset Font and Colors
$pdf->Ln(10);
$pdf->SetTextColor($font_color[0], $font_color[1], $font_color[2]);
$pdf->SetFont('Arial', 'B', 12);

// Personal Details
$pdf->Cell(30, 10, "Name:", 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $data['name'], 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30, 10, "Contact:", 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $data['contact'], 0, 1);

$pdf->Ln(5);

// Section Headers
function addSectionHeader($pdf, $title, $section_bg) {
    $pdf->SetFillColor($section_bg[0], $section_bg[1], $section_bg[2]);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(190, 10, $title, 0, 1, 'L', true);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln(2);
}

// Bio Section
addSectionHeader($pdf, "Bio", $section_bg);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(190, 8, $data['bio']);
$pdf->Ln(5);

// Skills Section
addSectionHeader($pdf, "Skills", $section_bg);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, "Soft Skills:", 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $data['soft_skills'], 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, "Technical Skills:", 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $data['technical_skills'], 0, 1);

$pdf->Ln(5);

// Education Section
addSectionHeader($pdf, "Education", $section_bg);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, "BSc Degree:", 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $data['bsc_degree'], 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, "BSc Institute:", 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $data['bsc_institute'], 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, "BSc CGPA:", 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $data['bsc_cgpa'], 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, "BSc Year:", 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $data['bsc_year'], 0, 1);

$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, "MSc Degree:", 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $data['msc_degree'], 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, "MSc Institute:", 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $data['msc_institute'], 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, "MSc CGPA:", 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $data['msc_cgpa'], 0, 1);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, "MSc Year:", 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $data['msc_year'], 0, 1);

$pdf->Ln(5);

// Experience Section
addSectionHeader($pdf, "Experience", $section_bg);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(190, 8, $data['experience']);
$pdf->Ln(5);

// Projects Section
addSectionHeader($pdf, "Projects", $section_bg);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(190, 8, $data['projects']);
$pdf->Ln(5);

// Output PDF
$pdf->Output();
?>
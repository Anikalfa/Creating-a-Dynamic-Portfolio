<?php
require 'config/db.php';
require 'vendor/autoload.php'; // Using MPDF library

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM portfolios WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$mpdf = new \Mpdf\Mpdf();
$html = "
    <h1>{$data['full_name']}</h1>
    <p><strong>Contact:</strong> {$data['contact']}</p>
    <p><strong>Bio:</strong> {$data['bio']}</p>
    <p><strong>Skills:</strong> {$data['skills']}</p>
    <p><strong>Education:</strong> {$data['education']}</p>
    <p><strong>Experience:</strong> {$data['experience']}</p>
    <p><strong>Projects:</strong> {$data['projects']}</p>
";

$mpdf->WriteHTML($html);
$mpdf->Output("portfolio.pdf", "D");
?>

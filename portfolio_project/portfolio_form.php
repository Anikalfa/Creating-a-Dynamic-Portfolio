<?php
require 'config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $contact = $_POST['contact'];
    $bio = $_POST['bio'];
    $skills = $_POST['skills'];
    $education = $_POST['education'];
    $experience = $_POST['experience'];
    $projects = $_POST['projects'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO portfolios (user_id, full_name, contact, bio, skills, education, experience, projects) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $user_id, $full_name, $contact, $bio, $skills, $education, $experience, $projects);
    
    if ($stmt->execute()) {
        echo "<script>alert('Portfolio saved! Generating PDF...'); window.location.href='generate_pdf.php';</script>";
    } else {
        echo "<script>alert('Error saving portfolio!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Portfolio Form</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Create Your Portfolio</h2>
        <form action="portfolio_form.php" method="POST">
            <input type="text" name="full_name" required placeholder="Full Name"><br>
            <input type="text" name="contact" required placeholder="Contact Info"><br>
            <input type="text" name="bio" required placeholder="Short Bio"><br>
            <input type="text" name="Skills" required placeholder="Soft & Technical Skills"><br>
            <input type="text" name="education" required placeholder="Academic Background (Optional)"><br>
            <input type="text" name="experience" required placeholder="Work Experience"><br>
            <input type="text" name="projects" required placeholder="Projects/Publications (Optional)"><br>
            <button type="submit">Generate PDF</button>
        </form>
    </div>
</body>
</html>

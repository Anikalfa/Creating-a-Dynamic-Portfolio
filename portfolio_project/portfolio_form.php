<?php
// Start session
session_start();
include 'config/db.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $bio = $_POST['bio'];
    $soft_skills = $_POST['soft_skills'];
    $technical_skills = $_POST['technical_skills'];
    $bsc_cgpa = $_POST['bsc_cgpa'];
    $bsc_institute = $_POST['bsc_institute'];
    $bsc_degree = $_POST['bsc_degree'];
    $bsc_year = $_POST['bsc_year'];
    $msc_cgpa = $_POST['msc_cgpa'];
    $msc_institute = $_POST['msc_institute'];
    $msc_degree = $_POST['msc_degree'];
    $msc_year = $_POST['msc_year'];
    $experience = $_POST['experience'];
    $projects = $_POST['projects'];

    // Handle profile photo upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photo_name = time() . '_' . $_FILES['photo']['name'];
        $photo_tmp = $_FILES['photo']['tmp_name'];
        $photo_path = "uploads/" . $photo_name;
        move_uploaded_file($photo_tmp, $photo_path);
    } else {
        $photo_path = NULL;
    }

    // Insert into database
    $sql = "INSERT INTO portfolios 
        (user_id, name, contact, photo, bio, soft_skills, technical_skills, 
        bsc_cgpa, bsc_institute, bsc_degree, bsc_year, 
        msc_cgpa, msc_institute, msc_degree, msc_year, 
        experience, projects) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "issssssssssssssss",
        $user_id, $name, $contact, $photo_path, $bio, $soft_skills, $technical_skills,
        $bsc_cgpa, $bsc_institute, $bsc_degree, $bsc_year,
        $msc_cgpa, $msc_institute, $msc_degree, $msc_year,
        $experience, $projects
    );

    if ($stmt->execute()) {
        header("Location: portfolio_view.php");
        exit();
    } else {
        echo "<p class='error'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Portfolio</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h2>Portfolio</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="text" name="contact" placeholder="Contact" required>
        </div>
        <div class="form-group">
            <label>Profile Photo:</label>
            <input type="file" name="photo">
        </div>
        <textarea name="bio" placeholder="Short Bio"></textarea>

        <h3>Skills</h3>
        <div class="form-group">
            <input type="text" name="soft_skills" placeholder="Soft Skills">
            <input type="text" name="technical_skills" placeholder="Technical Skills">
        </div>

        <h3>Education</h3>
        <div class="form-group">
            <input type="text" name="bsc_degree" placeholder="BSc Degree">
            <input type="text" name="bsc_institute" placeholder="BSc Institute">
            <input type="text" name="bsc_year" placeholder="BSc Year">
            <input type="text" name="bsc_cgpa" placeholder="BSc CGPA">
        </div>
        <div class="form-group">
            <input type="text" name="msc_degree" placeholder="MSc Degree">
            <input type="text" name="msc_institute" placeholder="MSc Institute">
            <input type="text" name="msc_year" placeholder="MSc Year">
            <input type="text" name="msc_cgpa" placeholder="MSc CGPA">
        </div>

        <h3>Experience & Projects</h3>
        <textarea name="experience" placeholder="Your Experience"></textarea>
        <textarea name="projects" placeholder="Your Projects"></textarea>

        <button type="submit" class="btn-submit">Submit Portfolio</button>

    </form>
</div>
</body>
</html>


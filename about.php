<?php
include 'config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Ensure the doctor ID is a valid number
$doctor_id = isset($_GET['doctor_id']) ? intval($_GET['doctor_id']) : 0;

// Check if the doctor ID exists in the database
$doctor_check = $conn->query("SELECT * FROM doctors WHERE id = $doctor_id");
if ($doctor_check->num_rows == 0) {
    $doctor_id = 0; // Set to 0 if doctor ID is not valid
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_id = $_POST['doctor_id'];
    $patient_id = $_POST['patient_id'];
    $appointment_date = $_POST['appointment_date'];

    // Check if the doctor ID exists in the database again before inserting
    $doctor_check = $conn->query("SELECT * FROM doctors WHERE id = $doctor_id");
    if ($doctor_check->num_rows > 0) {
        $sql = "INSERT INTO appointments (doctor_id, patient_id, appointment_date) VALUES ('$doctor_id', '$patient_id', '$appointment_date')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New appointment added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: Doctor ID is invalid.";
    }
}

// Fetch patients data from the database
$patients = $conn->query("SELECT * FROM patients");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: #90EE90; /* Light green background */
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #333;
        }
        p {
            font-size: 18px;
            line-height: 1.6;
            color: #333;
        }
        .social-media {
            list-style: none;
            padding: 0;
        }
        .social-media li {
            display: inline;
            margin-right: 10px;
        }
        .social-media a {
            text-decoration: none;
            color: #fff;
            background-color: #333;
            padding: 10px 15px;
            border-radius: 4px;
        }
        .map {
            margin-top: 20px;
        }
        nav ul.menu {
            list-style: none;
            padding: 0;
            margin-top: 20px;
            display: flex;
            justify-content: space-around;
        }
        nav ul.menu li {
            display: inline;
        }
        nav ul.menu li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tentang Kami</h1>
        <p>Selamat datang di hotel kami. Kami berkomitmen untuk memberikan pelayanan terbaik dan pengalaman menginap yang tak terlupakan. Kunjungi kami dan nikmati fasilitas yang kami tawarkan.</p>

        <h2>Ikuti Kami</h2>
        <ul class="social-media">
            <li><a href="https://www.instagram.com/your_instagram" target="_blank">Instagram</a></li>
            <li><a href="https://www.tiktok.com/@your_tiktok" target="_blank">TikTok</a></li>
            <li><a href="https://www.facebook.com/your_facebook" target="_blank">Facebook</a></li>
        </ul>

        <h2>Lokasi Kami</h2>
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3163.244702938461!2d-122.0842496847058!3d37.42206577982579!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fb5b7c7e3b7e1%3A0x1b0dcd5291c70b1b!2sGoogleplex!5e0!3m2!1sen!2sus!4v1602495790047!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>

        <nav>
            <ul class="menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="add_doctors.php">Doctor</a></li>
                <li><a href="add_patients.php">Patient</a></li>
                <li><a href="add_appointments.php">Appointment</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="doctors_list.php">Doctors Profile</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>

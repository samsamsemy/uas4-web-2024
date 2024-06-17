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
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <title>Appointment</title>
    <link rel="stylesheet" href="style-appointment.css" />
  </head>
  <body>
    <div class="center">
      <h1>Create Appointment</h1>
      <form method="post">
        <div class="txt_field">
          <input type="text" required />
          <span></span>
          <label>Doctor ID</label>
        </div>
        <div class="txt_field">
          <input type="text" required />
          <span></span>
          <label>Patient ID</label>
        </div>
        <div class="txt_field">
          <input type="date" required />
          <span></span>
          <label>Appointment Date</label>
        </div>
        <input type="submit" value="Create Appointment" />
        <div class="bottom-form"></div>
      </form>
    </div>
  </body>
</html>


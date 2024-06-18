<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_id = $_POST['doctor_id'];
    $patient_id = $_POST['patient_id'];
    $appointment_date = $_POST['appointment_date'];

    $sql = "INSERT INTO appointments (doctor_id, patient_id, appointment_date) VALUES ('$doctor_id', '$patient_id', '$appointment_date')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New appointment added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

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
            <input type="text" name="doctor_id" required />
            <span></span>
            <label>Doctor ID</label>
        </div>
        <div class="txt_field">
            <input type="text" name="patient_id" required />
            <span></span>
            <label>Patient ID</label>
        </div>
        <div class="txt_field">
            <input type="date" name="appointment_date" required />
            <span></span>
            <label>Appointment Date</label>
        </div>
        <input type="submit" value="Create Appointment" />
        <div class="bottom-form"></div>
    </form>
</div>
</body>
</html>

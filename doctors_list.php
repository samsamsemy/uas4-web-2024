<?php
include 'config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Fetch doctors data from the database
$doctors = $conn->query("SELECT * FROM doctors");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors List</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: #ADD8E6; /* Light blue background */
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
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #333;
        }
        .header p {
            font-size: 18px;
            color: #666;
        }
        .doctor-list {
            margin-bottom: 20px;
        }
        .doctor-profile {
            background-color: #90EE90; /* Light green background */
            padding: 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .doctor-profile h2 {
            color: #333;
            margin-bottom: 10px;
        }
        .doctor-profile p {
            font-size: 16px;
            color: #666;
        }
        .appointment-link {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 10px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        nav ul.menu {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: space-around;
            background-color: #333;
            padding: 10px;
            border-radius: 8px;
        }
        nav ul.menu li {
            display: inline;
        }
        nav ul.menu li a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Profil Dokter</h1>
            <p>Daftar dokter yang bekerja di rumah sakit kami</p>
        </div>
        <div class="doctor-list">
            <?php if ($doctors->num_rows > 0): ?>
                <?php while($doctor = $doctors->fetch_assoc()): ?>
                    <div class="doctor-profile">
                        <h2><?php echo htmlspecialchars($doctor['name']); ?></h2>
                        <p>Spesialisasi: <?php echo htmlspecialchars($doctor['specialization']); ?></p>
                        <a href="add_appointments.php?doctor_id=<?php echo $doctor['id']; ?>" class="appointment-link">Buat Janji Temu</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Tidak ada dokter yang terdaftar.</p>
            <?php endif; ?>
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

<?php
$conn->close();
?>

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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hospital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
</head>

<body>
    <style>
    @import url("https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap");

    /* variabel */
    :root {
        --c-brand: #0c8cdc;
        --c-brand-rgb: 254, 54, 145;
        --c-dark: #044269;
        --c-body: #7aa5c2;
        --f-main: "Nunito Sans", sans-serif;
        --transition: 0.2s ease-in-out;
        --shadow: 0px 15px 40px rgba(0, 0, 0, 0.1);
    }

    /* Reset and Helpers */
    body {
        font-family: var(--f-main);
        color: var(--c-body);
        line-height: 1.7;
        background-color: white;
    }

    h1,
    .h1,
    h2,
    .h2,
    h3,
    .h3,
    h4,
    .h4,
    h5,
    .h5,
    h6,
    .h6 {
        font-weight: 700;
        color: var(--c-dark);
    }

    a {
        text-decoration: none;
        color: var(--c-dark);
        transition: var(--transition);
    }

    a:hover {
        color: var(--c-brand);
    }

    img {
        width: 100%;
    }

    .section-padding {
        padding-top: 120px;
        padding-bottom: 120px;
    }

    .text-brand {
        color: var(--c-brand);
    }

    /* Navbar */
    .navbar {
        padding-top: 20px;
        padding-bottom: 20px;
        background-color: white;
        transition: var(--transition);
    }

    .navbar.scrolled {
        padding-top: 7px;
        padding-bottom: 7px;
        background-color: white;
    }

    @media (min-width: 992px) {
        .navbar-expand-lg .navbar-nav .nav-link {
            padding-right: 16px;
            padding-left: 16px;
        }
    }

    .navbar .navbar-nav .nav-link {
        font-weight: 500;
        text-transform: uppercase;
        color: var(--c-dark);
    }

    .navbar .navbar-nav .nav-link:hover {
        color: var(--c-brand);
    }

    .navbar-brand {
        font-size: 24px;
        font-weight: 700;
        color: var(--c-dark);
    }

    .social-icon {
        width: 36px;
        height: 36px;
        margin-right: 6px;
        background-color: var(--c-brand);
        color: white;
        border: 2px solid var(--c-brand);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .social-icon:hover {
        background-color: white;
    }

    /* btn */
    .btn {
        padding: 10px 24px;
        border-radius: 0;
        border-width: 2px;
        font-weight: 500;
    }

    .btn-brand {
        background-color: var(--c-brand);
        color: white;
        border-color: var(--c-brand);
    }

    .btn-brand:hover {
        border-color: var(--c-brand);
    }

    .btn-brand:focus {
        background-color: var(--c-brand);
    }

    /* home */
    #Home {
        /* background-image: url(ppp.png); */
        background-position: center;
        background-size: cover;
    }
    </style>
    <!-- NAVBAR -->
    <div>
        <nav id="navbar" class="navbar navbar-expand-lg fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">Hospital</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add_doctors.php">Doctor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add_patients.php">Patient</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add_appointments.php">Appointment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="doctors_list.php">Doctor Profile</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="social-icon" href="contact.php"><i class="ri-contacts-book-3-line"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- CONTENT -->
        <section id="Home" class="d-flex align-items-center min-vh-100">
            <div class="container">
                <div class="d-flex flex-column mb-3">
                    <div class="p-2">
                        <h1 class="display-2 fw-bold">Tentang kami</h1>
                    </div>
                    <div class="p-2">
                        <p class="fs-3">
                            Selamat datang di hotel kami. Kami berkomitmen untuk memberikan
                            pelayanan terbaik dan pengalaman menginap yang tak terlupakan.
                            Kunjungi kami dan nikmati fasilitas yang kami tawarkan.
                        </p>
                    </div>
                    <div class="">
                        <div class="d-flex flex-row mb-3">
                            <div class="p-2">
                                <a href="" class="btn btn-brand">facebook</a>
                            </div>
                            <div class="p-2">
                                <a href="" class="btn btn-brand">facebook</a>
                            </div>
                            <div class="p-2">
                                <a href="" class="btn btn-brand">facebook</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- CONTENT END -->

        <!-- CONTENT 2-->
        <section id="Home" class="d-flex align-items-center min-vh-100">
            <div class="container">
                <div class="d-flex flex-column mb-3">
                    <div class="p-2">
                        <h1 class="display-6 fw-bold text-center">Temukan lokasi Kami</h1>
                    </div>
                    <div class="p-2">
                        <p class="fs-5 text-center">
                            Rumah Sakit Kami berlokasi di Universitas Pembangunan Nasional
                            "Veteran" Jakarta. Nikmati akses mudah dan layanan medis
                            berkualitas tinggi dari tim profesional kami, siap memberikan
                            perawatan terbaik untuk Anda.
                        </p>
                    </div>
                    <div class="p-2">
                        <div class="map-responsive">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.5402364210375!2d106.7917855!3d-6.3157399!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ee3e065d4f6b%3A0xe176f81a31564166!2sUniversitas%20Pembangunan%20Nasional%20%22Veteran%22%20Jakarta!5e0!3m2!1sen!2sus!4v1602495790047!5m2!1sen!2sus"
                                width="100%" height="450" style="border: 0" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CONTENT 2 END -->
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>

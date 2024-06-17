<?php
include 'config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Fetch data from the database
$doctors = $conn->query("SELECT * FROM doctors");
$patients = $conn->query("SELECT * FROM patients");
$appointments = $conn->query("SELECT appointments.id, doctors.name AS doctor_name, patients.name AS patient_name, appointment_date 
                              FROM appointments
                              JOIN doctors ON appointments.doctor_id = doctors.id
                              JOIN patients ON appointments.patient_id = patients.id");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Hospital</title>
    <!-- <link rel="stylesheet" href="assets/css-bootstrap/bootstrap.css" /> -->
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
    <nav id="navbar" class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Hospital</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"></li>
                    <li class="nav-item">
                        <a class="nav-link" href="#dasboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#add_doctors.php">Doctor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#add_patients">Patient</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#add_appointments">Appointment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#doctor_list.php">Doctor Profile</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="social-icon" href="#contact"><i class="ri-contacts-book-3-line"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HOME -->
    <section id="Home" class="d-flex align-items-center min-vh-100">
        <div class="container">
            <div class="col sm align-items-center">
                <h1 class="display-2 fw-bold">
                    Selamat datang di<span class="text-brand"> Hostpital</span>
                </h1>
                <h4 class="mt-3 mb-5">
                    Atur jadwal dan keperluan mu dengan dokter yang tersedia dimanapun
                </h4>
                <a href="" class="btn btn-brand">Cek jadwal sekarang</a>
            </div>
        </div>
    </section>
    <!-- HOME END -->
    </section>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>


<?php
$conn->close();
?>
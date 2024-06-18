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
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
      rel="stylesheet"
    />
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

      /* slider */
      .slider-katalog {
        display: flex;
        overflow-x: auto; /* Untuk membuatnya dapat digulir */
        scrollbar-width: none; /* Untuk menyembunyikan scrollbar pada browser */
        -ms-overflow-style: none; /* Untuk menyembunyikan scrollbar pada Internet Explorer */
      }

      .slider-katalog::-webkit-scrollbar {
        display: none; /* Untuk menyembunyikan scrollbar pada browser WebKit */
      }

      /* home */
      #Home {
        /* background-image: url(ppp.png); */
        background-position: center;
        background-size: cover;
      }

      /* konten 1 */
      .content-1 {
        padding: 50px;
        /* background-color: wheat; */
      }

      /* footer */
      footer{
        /* background-color: var(--c-brand); */
      }
    </style>
    <!-- NAVBAR -->
    <nav id="navbar" class="navbar navbar-expand-lg fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Hospital</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item"></li>
            <li class="nav-item">
              <a class="nav-link" href="#dashboard.php">Dashboard</a>
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
              <a class="social-icon" href="#contact"
                ><i class="ri-contacts-book-3-line"></i
              ></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- navbar end -->

    <!-- HOME -->
    <section id="Home" class="d-flex align-items-center min-vh-100">
      <div class="container">
        <div class="col sm text-center">
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

    <!-- CONTENT 1 -->
    <section class="content-1 d-flex">
      <div class="container">
        <div class="align-items-center text-center pb-4">
          <h1>CEK CARA HIDUP SEHAT</h1>
          <p class="fs-6">
            Hidup sehat adalah tentang makan dengan bijak, bergerak cukup, tidur
            yang cukup, dan merawat tubuh secara baik, termasuk kulit.
          </p>
        </div>
        <div class="container align-items-center text-center">
          <div
            class="row border-bottom border-black pt-2 justify-content-center"
          >
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 p-0 fs-5">
            <a href="./content/vitamin.html">Vitamin</a>
          </div>
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 p-0 fs-5">
            <a href="./content/cek-gula.html">Cek Gula</a>
          </div>
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 p-0 fs-5">
            <a href="./content/obesitas.html">Obesitas</a>
          </div>
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 p-0 fs-5">
            <a href="./content/jantung.html">Jantung</a>
          </div>
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 p-0 fs-5">
            <a href="./content/pola-diet.html">Pola diet</a>
          </div>
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 p-0 fs-5">
            <a href="./content/pola-istirahat.html">Pola Istirahat</a>
          </div>
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 p-0 fs-5">
            <a href="./content/olahraga.html">Olahraga</a>
          </div>
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 p-0 fs-5">
            <a href="./content/kulit.html">Kulit</a>
          </div>
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 p-0 fs-5">
            <a href="./content/gizi.html">Gizi</a>
          </div>
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 p-0 fs-5">
            <a href="./content/mental.html">Kesehatan Mental</a>
          </div>
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 p-0 fs-5">
            <a href="./content/kanker.html">Kanker</a>
          </div>
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 p-0 fs-5">
            <a href="./content/pencernaan.html">Pencernaan</a>
          </div>
          
          </div>
          <!-- carousel -->
          <div id="carouselExample" class="carousel slide mt-5">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="./content/assets/diet.jpeg" class="d-block w-100" alt="..." />
              </div>
              <div class="carousel-item">
                <img src="./content/assets/gula-darah.jpeg" class="d-block w-100" alt="..." />
              </div>
              <div class="carousel-item">
                <img
                  src="./content/assets/jantung.jpeg"
                  class="d-block w-100"
                  alt="..."
                />
              </div>
              <div class="carousel-item">
                <img
                  src="./content/assets/olahraga.jpeg"
                  class="d-block w-100"
                  alt="..."
                />
              </div>
              <div class="carousel-item">
                <img
                  src="./content/assets/hidup.jpeg"
                  class="d-block w-100"
                  alt="..."
                />
              </div>
            </div>
            <button
              class="carousel-control-prev"
              type="button"
              data-bs-target="#carouselExample"
              data-bs-slide="prev"
            >
              <span
                class="carousel-control-prev-icon"
                aria-hidden="true"
              ></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button
              class="carousel-control-next"
              type="button"
              data-bs-target="#carouselExample"
              data-bs-slide="next"
            >
              <span
                class="carousel-control-next-icon"
                aria-hidden="true"
              ></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
          <!-- carousel end -->

          <!-- konten berita -->
          <div class="container mt-5">
            <div class="row g-2">
              <!-- Kolom 1 -->
              <div class="col-12 col-md-6">
                <div class="p-3 border border-dark text-start">
                  <div class="row g-2">
                    <div class="col-12 col-md-6">
                      <div class="p-3 text-center">
                        <img src="assets/pp.png" alt="" class="img-fluid" />
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="p-3">
                        <h6>Ini berita</h6>
                        <p>
                          Lorem ipsum dolor sit amet consectetur adipisicing elit.
                          Repellendus cum rem dolorem.
                        </p>
                        <a href="" class="">baca selengkapnya</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Kolom 2 -->
              <div class="col-12 col-md-6">
                <div class="p-3 border border-dark text-start">
                  <div class="row g-2">
                    <div class="col-12 col-md-6">
                      <div class="p-3 text-center">
                        <img src="assets/pp.png" alt="" class="img-fluid" />
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="p-3">
                        <h6>Ini berita</h6>
                        <p>
                          Lorem ipsum dolor sit amet consectetur adipisicing elit.
                          Repellendus cum rem dolorem.
                        </p>
                        <a href="" class="">baca selengkapnya</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Kolom 3 -->
              <div class="col-12 col-md-6">
                <div class="p-3 border border-dark text-start">
                  <div class="row g-2">
                    <div class="col-12 col-md-6">
                      <div class="p-3">
                        <img src="assets/pp.png" alt="" class="img-fluid" />
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="p-3">
                        <h6>Ini berita</h6>
                        <p>
                          Lorem ipsum dolor sit amet consectetur adipisicing elit.
                          Repellendus cum rem dolorem.
                        </p>
                        <a href="" class="">baca selengkapnya</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Kolom 4 -->
              <div class="col-12 col-md-6">
                <div class="p-3 border border-dark text-start">
                  <div class="row g-2">
                    <div class="col-12 col-md-6">
                      <div class="p-3">
                        <img src="assets/pp.png" alt="" class="img-fluid" />
                      </div>
                    </div>
                    <div class="col-12 col-md-6">
                      <div class="p-3">
                        <h6>Ini berita</h6>
                        <p>
                          Lorem ipsum dolor sit amet consectetur adipisicing elit.
                          Repellendus cum rem dolorem.
                        </p>
                        <a href="" class="">baca selengkapnya</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- konten berita end -->

            <!-- konten berita 2 -->
              <div class="row g-2 mt-5">
                <!-- Kolom 1 -->
                <div class="col-12">
                  <div class="p-3 border border-dark text-start">
                    <div class="row g-2">
                      <div class="col-12 col-md-6">
                        <div class="p-3">
                          <img src="assets/pp.png" alt="" class="img-fluid" />
                        </div>
                      </div>
                      <div class="col-12 col-md-6">
                        <div class="p-3">
                          <h6>Ini berita</h6>
                          <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Repellendus cum rem dolorem.
                          </p>
                          <a href="" class="">baca selengkapnya</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Kolom 2 -->
                <div class="col-12 my-2">
                  <div class="p-3 border border-dark text-start">
                    <div class="row g-2">
                      <div class="col-12 col-md-6">
                        <div class="p-3">
                          <img src="assets/pp.png" alt="" class="img-fluid" />
                        </div>
                      </div>
                      <div class="col-12 col-md-6">
                        <div class="p-3">
                          <h6>Ini berita</h6>
                          <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Repellendus cum rem dolorem.
                          </p>
                          <a href="" class="">baca selengkapnya</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Kolom 3 -->
                <div class="col-12">
                  <div class="p-3 border border-dark text-start">
                    <div class="row g-2">
                      <div class="col-12 col-md-6">
                        <div class="p-3">
                          <img src="assets/pp.png" alt="" class="img-fluid" />
                        </div>
                      </div>
                      <div class="col-12 col-md-6">
                        <div class="p-3">
                          <h6>Ini berita</h6>
                          <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Repellendus cum rem dolorem.
                          </p>
                          <a href="" class="">baca selengkapnya</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
           <!-- konten berita 2 end -->
        </div>
      </div>
    </section>
    <!-- CONTENT 1 END -->

    <!-- footer -->
     <footer class="text-center my-3">
      <h6>&copy kelompok web UPNVJ 2024</h6>
     </footer>
    <!-- footer end -->

    <!-- JS -->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <script src="app.js"></script>
  </body>
</html>



<?php
$conn->close();
?>

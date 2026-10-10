<?php
// เริ่มต้น Session สำหรับจัดการสถานะการล็อกอิน (ถ้าต้องการใช้งาน)
session_start();

$error_message = "";

// ตัวอย่างการรับค่าเมื่อมีการกด Submit ฟอร์ม
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // TODO: ใส่โค้ดเชื่อมต่อฐานข้อมูลและตรวจสอบสิทธิ์ (Authentication) ตรงนี้
    // ตัวอย่างจำลอง:
    if ($username === "admin" && $password === "1234") {
        $_SESSION['user'] = $username;
        header("Location: index.php"); // ไปยังหน้าหลักหลังล็อกอินสำเร็จ
        exit();
    } else {
        $error_message = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>TalentMatrix</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Kelly
  * Template URL: https://bootstrapmade.com/kelly-free-bootstrap-cv-resume-html-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center light-background sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">TalentMatrix</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.html">Home</a></li>  
		  <li class="dropdown"><a href="company_main.html" class="active"><span>Main Menu</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
             <ul>
			  <li><a href="company_registration.php">Company Registration</a></li>
              <li><a href="map_organization.php">Develop Competency Framework</a></li>
		
              <li class="dropdown"><a href="#"><span>Competency Assessment</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Assess Your team</a></li>
                  <li><a href="#">Assess Yourself</a></li>
                  <li><a href="#">Search for Trainer</a></li>
				  <li><a href="#">Organization Dashboard</a></li>
                </ul>
              </li>
			
			  <li class="dropdown"><a href="#"><span>Result</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
				  <li><a href="#">See your assessment result</a></li>
				  <li><a href="#">See your IDP</a></li>
				</ul>
			  </li>
			  <li><a href="#">Dashboard</a></li>
			  <li><a href="#">Search for Trainer</a></li>
			</ul>
		   </li>		  
          <li><a href="training_courses.html">Training Courses</a></li>
		  <li><a href="about.html">About</a></li> 
		  <li><a href="contact.html">Contact</a></li>		  
        </ul>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="header-social-links">
	    <a href="#" class="log in" title="Log in"><i class="bi bi-person-circle"></i></a>
        <a href="#" class="facebook" title="facebook"><i class="bi bi-facebook"></i></a>
        <!-- เพิ่มปุ่มเปลี่ยนภาษา -->
        <a href="#" class="language-th" title="ภาษาไทย">TH</a>
        <a href="#" class="language-en" title="English">EN</a>		
      </div>

    </div>
  </header>

  <main class="main">

    <!-- Login Section -->
    <section id="login" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Log in</h2>
        <p>Log in to assess your team, query training courses.</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
          <div class="col-lg-5 col-md-8">
            <div class="card shadow-sm border-0 p-4" style="background-color: #fff; border-radius: 8px;">
              
              <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo htmlspecialchars($error_message); ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>

              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="php-email-form">
                <div class="mb-3">
                  <label for="username" class="form-label fw-semibold">Username or Email</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Enter your username" required>
                  </div>
                </div>

                <div class="mb-4">
                  <label for="password" class="form-label fw-semibold">Password</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                  </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember">
                    <label class="form-check-label text-muted" for="remember">Remember me</label>
                  </div>
                  <a href="#" class="text-decoration-none small text-primary">Forgot Password?</a>
                </div>

                <div class="d-grid">
                  <button type="submit" class="btn btn-dark py-2">Sign In</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>

    </section><!-- /Login Section -->

  </main>

  <footer id="footer" class="footer light-background">
    <div class="container">
      <div class="copyright text-center">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">Kelly</strong> <span>All Rights Reserved<br></span></p>
      </div>
      <div class="social-links d-flex justify-content-center">
        <a href=""><i class="bi bi-twitter-x"></i></a>
        <a href=""><i class="bi bi-facebook"></i></a>
        <a href=""><i class="bi bi-instagram"></i></a>
        <a href=""><i class="bi bi-linkedin"></i></a>
      </div>
      <div class="credits">
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> Distributed by <a href="https://themewagon.com">ThemeWagon</a>
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
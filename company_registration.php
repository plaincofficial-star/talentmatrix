<?php
// Initialize message variables
$success_message = "";
$error_message = "";

// Handle form submission via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and collect input data
    $company_name = trim($_POST['company_name'] ?? '');
    $business_type = trim($_POST['business_type'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $coordinator_name = trim($_POST['coordinator_name'] ?? '');
    $contact_number = trim($_POST['contact_number'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $package = trim($_POST['package'] ?? '');

    // Simple validation
    if (empty($company_name) || empty($business_type) || empty($address) || empty($coordinator_name) || empty($contact_number) || empty($email) || empty($package)) {
        $error_message = "กรุณากรอกข้อมูลให้ครบทุกช่อง (Please fill in all required fields.)";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "รูปแบบอีเมลไม่ถูกต้อง (Invalid email format.)";
    } else {
        // In a real application, you would save data to a database here.
        // For demonstration purposes, we show a success message.
        $success_message = "ลงทะเบียนบริษัทสำเร็จ! ขอบคุณที่สมัครใช้งานระบบของเรา (Company registration successful! Thank you for registering.)";
        
        // Clear variables after successful submit if desired
        $company_name = $business_type = $address = $coordinator_name = $contact_number = $email = $package = "";
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
                  <li><a href="assess_yourstaff.php">Assess Your team</a></li>
                  <li><a href="assess_yourself.php">Assess Yourself</a></li>
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
	    <a href="login.php" class="log in" title="Log in"><i class="bi bi-person-circle"></i></a>
        <a href="#" class="facebook" title="facebook"><i class="bi bi-facebook"></i></a>
        <!-- เพิ่มปุ่มเปลี่ยนภาษา -->
        <a href="#" class="language-th" title="ภาษาไทย">TH</a>
        <a href="#" class="language-en" title="English">EN</a>		
      </div>

    </div>
  </header>

  <main class="main">

    <!-- Registration Section -->
    <section id="register-section" class="starter-section section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>ลงทะเบียนใช้งานระบบ<br>
        (Company Registration)<br></h2>
        <p>กรอกข้อมูลบริษัทและเลือกแพ็กเกจที่ต้องการใช้งานระบบ เพื่อเริ่มต้นใช้งานได้ทันที</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            
            <!-- Success/Error Alerts -->
            <?php if (!empty($success_message)): ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?php echo $success_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $error_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>

            <!-- Registration Form -->
            <form action="register.php" method="POST" class="php-email-form bg-white p-4 p-md-5 rounded shadow-sm">
              
              <div class="row gy-4">

                <!-- 1. ชื่อบริษัท -->
                <div class="col-md-12">
                  <label for="company_name" class="form-label fw-bold">ชื่อบริษัท (Company Name) <span class="text-danger">*</span></label>
                  <input type="text" name="company_name" id="company_name" class="form-control" placeholder="ระบุชื่อบริษัทของคุณ" value="<?php echo htmlspecialchars($company_name ?? ''); ?>" required>
                </div>

                <!-- 2. ประเภทธุรกิจ -->
                <div class="col-md-6">
                  <label for="business_type" class="form-label fw-bold">ประเภทธุรกิจ (Business Type) <span class="text-danger">*</span></label>
                  <select name="business_type" id="business_type" class="form-select" required>
                    <option value="" disabled selected>-- เลือกประเภทธุรกิจ --</option>
                    <option value="Technology / Software" <?php if(isset($business_type) && $business_type=='Technology / Software') echo 'selected'; ?>>Technology / Software</option>
                    <option value="E-Commerce / Retail" <?php if(isset($business_type) && $business_type=='E-Commerce / Retail') echo 'selected'; ?>>E-Commerce / Retail</option>
                    <option value="Manufacturing" <?php if(isset($business_type) && $business_type=='Manufacturing') echo 'selected'; ?>>Manufacturing (การผลิต)</option>
                    <option value="Services / Consulting" <?php if(isset($business_type) && $business_type=='Services / Consulting') echo 'selected'; ?>>Services / Consulting (บริการ/ที่ปรึกษา)</option>
                    <option value="Other" <?php if(isset($business_type) && $business_type=='Other') echo 'selected'; ?>>Other (อื่นๆ)</option>
                  </select>
                </div>

                <!-- 5. เบอร์ติดต่อ -->
                <div class="col-md-6">
                  <label for="contact_number" class="form-label fw-bold">เบอร์ติดต่อ (Contact Number) <span class="text-danger">*</span></label>
                  <input type="tel" name="contact_number" id="contact_number" class="form-control" placeholder="0812345678" value="<?php echo htmlspecialchars($contact_number ?? ''); ?>" required>
                </div>

                <!-- 4. ชื่อผู้ประสานงาน -->
                <div class="col-md-6">
                  <label for="coordinator_name" class="form-label fw-bold">ชื่อผู้ประสานงาน (Coordinator Name) <span class="text-danger">*</span></label>
                  <input type="text" name="coordinator_name" id="coordinator_name" class="form-control" placeholder="ชื่อ-นามสกุล ผู้ประสานงาน" value="<?php echo htmlspecialchars($coordinator_name ?? ''); ?>" required>
                </div>

                <!-- 6. Email -->
                <div class="col-md-6">
                  <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                  <input type="email" name="email" id="email" class="form-control" placeholder="name@company.com" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                </div>

                <!-- 3. ที่อยู่ -->
                <div class="col-md-12">
                  <label for="address" class="form-label fw-bold">ที่อยู่ (Address) <span class="text-danger">*</span></label>
                  <textarea name="address" id="address" class="form-control" rows="3" placeholder="ระบุที่อยู่บริษัท เลขที่, ถนน, แขวง/ตำบล, เขต/อำเภอ, จังหวัด, รหัสไปรษณีย์" required><?php echo htmlspecialchars($address ?? ''); ?></textarea>
                </div>

                <!-- 7. เลือก Package สำหรับใช้ระบบ -->
                <div class="col-md-12">
                  <label class="form-label fw-bold">เลือก Package สำหรับใช้ระบบ (Select Package) <span class="text-danger">*</span></label>
                  <div class="row g-3">
                    <div class="col-md-4">
                      <div class="form-check border p-3 rounded h-100 bg-light">
                        <input class="form-check-input" type="radio" name="package" id="pkg_starter" value="Starter" <?php if(isset($package) && $package=='Starter') echo 'checked'; ?> required>
                        <label class="form-check-label w-100 fw-semibold" for="pkg_starter">
                          Starter Package<br>
                          <span class="text-muted small fw-normal">เหมาะสำหรับธุรกิจเริ่มต้น (ใช้งานได้ 5 ผู้ใช้งาน)</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-check border p-3 rounded h-100 bg-light">
                        <input class="form-check-input" type="radio" name="package" id="pkg_pro" value="Professional" <?php if(isset($package) && $package=='Professional') echo 'checked'; ?>>
                        <label class="form-check-label w-100 fw-semibold" for="pkg_pro">
                          Professional Package<br>
                          <span class="text-muted small fw-normal">เหมาะสำหรับธุรกิจขนาดกลาง (ใช้งานได้ 20 ผู้ใช้งาน)</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-check border p-3 rounded h-100 bg-light">
                        <input class="form-check-input" type="radio" name="package" id="pkg_enterprise" value="Enterprise" <?php if(isset($package) && $package=='Enterprise') echo 'checked'; ?>>
                        <label class="form-check-label w-100 fw-semibold" for="pkg_enterprise">
                          Enterprise Package<br>
                          <span class="text-muted small fw-normal">สำหรับองค์กรขนาดใหญ่ (ไม่จำกัดผู้ใช้งาน)</span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Submit Button -->
                <div class="col-md-12 text-center mt-4">
                  <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">ยืนยันการลงทะเบียน (Submit Registration)</button>
                </div>

              </div>

            </form>

          </div>
        </div>
      </div>

    </section><!-- /Registration Section -->

  </main>

  <footer id="footer" class="footer light-background">
    <div class="container">
      <div class="copyright text-center ">
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
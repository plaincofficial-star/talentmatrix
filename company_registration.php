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
  <title>TalentMatrix - Company Registration</title>
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

  <!-- Custom Package Card Styling -->
  <style>
    .package-box {
      border: 2px solid #e9ecef;
      border-radius: 1rem;
      background: #fff;
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: 100%;
    }
    .package-box:hover {
      box-shadow: 0 .75rem 1.5rem rgba(0, 0, 0, 0.08);
      transform: translateY(-5px);
    }
    /* เมื่อถูกเลือก (Active State) */
    .package-box.selected-package {
      border-color: #0d6efd !important;
      background-color: #f8fbff !important;
      box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.15);
    }
    .feature-list {
      text-align: left;
      padding-left: 0;
      list-style: none;
    }
    .feature-list li {
      margin-bottom: 0.75rem;
      font-size: 0.9rem;
      color: #495057;
      display: flex;
      align-items: flex-start;
    }
    .feature-list li i {
      margin-top: 2px;
      margin-right: 8px;
      flex-shrink: 0;
    }
    .form-control:focus, .form-select:focus {
      border-color: #86b7fe;
      box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
  </style>
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center light-background sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
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
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="header-social-links">
	    <a href="login.php" class="log in" title="Log in"><i class="bi bi-person-circle"></i></a>
        <a href="#" class="facebook" title="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="language-th" title="ภาษาไทย">TH</a>
        <a href="#" class="language-en" title="English">EN</a>		
      </div>

    </div>
  </header>

  <main class="main">

    <!-- Registration Section -->
    <section id="register-section" class="starter-section section py-5">

      <!-- Section Title -->
      <div class="container section-title text-center mb-5" data-aos="fade-up">
        <h2>ลงทะเบียนใช้งานระบบ</h2>
        <p class="text-muted">Company Registration — กรอกข้อมูลบริษัทและเลือกแพ็กเกจที่ต้องการใช้งานระบบ เพื่อเริ่มต้นใช้งานได้ทันที</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up">
        <div class="row justify-content-center">
          <div class="col-lg-10">
            
            <!-- Success/Error Alerts -->
            <?php if (!empty($success_message)): ?>
              <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i> <?php echo $success_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
              <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i> <?php echo $error_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>

            <!-- Registration Form -->
            <form action="company_registration.php" method="POST" class="php-email-form bg-white p-4 p-md-5 rounded-4 shadow-sm border">
              
              <div class="row gy-4">

                <!-- 1. ชื่อบริษัท -->
                <div class="col-md-12">
                  <label for="company_name" class="form-label fw-semibold text-secondary">ชื่อบริษัท (Company Name) <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-building"></i></span>
                    <input type="text" name="company_name" id="company_name" class="form-control" placeholder="ระบุชื่อบริษัทของคุณ" value="<?php echo htmlspecialchars($company_name ?? ''); ?>" required>
                  </div>
                </div>

                <!-- 2. ประเภทธุรกิจ -->
                <div class="col-md-6">
                  <label for="business_type" class="form-label fw-semibold text-secondary">ประเภทธุรกิจ (Business Type) <span class="text-danger">*</span></label>
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
                  <label for="contact_number" class="form-label fw-semibold text-secondary">เบอร์ติดต่อ (Contact Number) <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                    <input type="tel" name="contact_number" id="contact_number" class="form-control" placeholder="0812345678" value="<?php echo htmlspecialchars($contact_number ?? ''); ?>" required>
                  </div>
                </div>

                <!-- 4. ชื่อผู้ประสานงาน -->
                <div class="col-md-6">
                  <label for="coordinator_name" class="form-label fw-semibold text-secondary">ชื่อผู้ประสานงาน (Coordinator Name) <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                    <input type="text" name="coordinator_name" id="coordinator_name" class="form-control" placeholder="ชื่อ-นามสกุล ผู้ประสานงาน" value="<?php echo htmlspecialchars($coordinator_name ?? ''); ?>" required>
                  </div>
                </div>

                <!-- 6. Email -->
                <div class="col-md-6">
                  <label for="email" class="form-label fw-semibold text-secondary">อีเมล (Email) <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" id="email" class="form-control" placeholder="name@company.com" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                  </div>
                </div>

                <!-- 3. ที่อยู่ -->
                <div class="col-md-12">
                  <label for="address" class="form-label fw-semibold text-secondary">ที่อยู่ (Address) <span class="text-danger">*</span></label>
                  <textarea name="address" id="address" class="form-control" rows="3" placeholder="ระบุที่อยู่บริษัท เลขที่, ถนน, แขวง/ตำบล, เขต/อำเภอ, จังหวัด, รหัสไปรษณีย์" required><?php echo htmlspecialchars($address ?? ''); ?></textarea>
                </div>

                <!-- 7. เลือก Package สำหรับใช้ระบบ -->
                <div class="col-md-12 mt-4">
                  <label class="form-label fw-semibold text-secondary mb-3">เลือก Package สำหรับใช้ระบบ (Select Package) <span class="text-danger">*</span></label>
                  
                  <div class="row g-4">
                    
                    <!-- Starter Package -->
                    <div class="col-lg-4">
                      <div id="card_starter" class="package-box p-4 <?php echo (isset($package) && $package=='Starter') ? 'selected-package' : ''; ?>">
                        <div>
                          <div class="text-center pb-3 border-bottom mb-3">
                            <span class="badge bg-secondary-subtle text-secondary px-3 py-1 rounded-pill mb-2">Starter</span>
                            <h4 class="fw-bold text-dark mb-1">Starter Package</h4>
                            <span class="text-muted small">เหมาะสำหรับธุรกิจเริ่มต้น</span>
                          </div>
                          <!-- รายละเอียดทางด้านซ้าย -->
                          <ul class="feature-list">
                            <li><i class="bi bi-check-circle-fill text-success"></i> <span>รองรับผู้ใช้งานสูงสุด 5 คน</span></li>
                            <li><i class="bi bi-check-circle-fill text-success"></i> <span>Competency Framework พื้นฐาน</span></li>
                            <li><i class="bi bi-check-circle-fill text-success"></i> <span>ระบบประเมินทีมงานและตนเอง</span></li>
                            <li><i class="bi bi-check-circle-fill text-success"></i> <span>แดชบอร์ดและ IDP แบบจำกัด</span></li>
                          </ul>
                        </div>
                        <div class="text-center mt-4 pt-2 border-top">
                          <input class="form-check-input d-none" type="radio" name="package" id="pkg_starter" value="Starter" <?php if(isset($package) && $package=='Starter') echo 'checked'; ?> required>
                          <button type="button" class="btn btn-outline-primary w-100 select-pkg-btn" data-target="pkg_starter">
                            <?php echo (isset($package) && $package=='Starter') ? '<i class="bi bi-check2"></i> เลือกแล้ว' : 'เลือกแพ็กเกจนี้'; ?>
                          </button>
                        </div>
                      </div>
                    </div>

                    <!-- Professional Package -->
                    <div class="col-lg-4">
                      <div id="card_pro" class="package-box p-4 position-relative border-primary <?php echo (isset($package) && $package=='Professional') ? 'selected-package' : ''; ?>">
                        <span class="position-absolute top-0 start-50 translate-middle badge bg-primary px-3 py-1 rounded-pill">แนะนำ (ยอดนิยม)</span>
                        <div>
                          <div class="text-center pb-3 border-bottom mb-3 mt-1">
                            <span class="badge bg-primary-subtle text-primary px-3 py-1 rounded-pill mb-2">Professional</span>
                            <h4 class="fw-bold text-dark mb-1">Professional</h4>
                            <span class="text-muted small">เหมาะสำหรับธุรกิจขนาดกลาง</span>
                          </div>
                          <!-- รายละเอียดทางด้านซ้าย -->
                          <ul class="feature-list">
                            <li><i class="bi bi-check-circle-fill text-success"></i> <span>รองรับผู้ใช้งานสูงสุด 20 คน</span></li>
                            <li><i class="bi bi-check-circle-fill text-success"></i> <span>Competency Framework ขั้นสูง (Custom)</span></li>
                            <li><i class="bi bi-check-circle-fill text-success"></i> <span>ระบบประเมินผลครบทุกฟังก์ชัน</span></li>
                            <li><i class="bi bi-check-circle-fill text-success"></i> <span>แดชบอร์ดองค์กรและ IDP เต็มรูปแบบ</span></li>
                            <li><i class="bi bi-check-circle-fill text-success"></i> <span>ซัพพอร์ตช่วยเหลือ 24/7 (Email/Chat)</span></li>
                          </ul>
                        </div>
                        <div class="text-center mt-4 pt-2 border-top">
                          <input class="form-check-input d-none" type="radio" name="package" id="pkg_pro" value="Professional" <?php if(isset($package) && $package=='Professional') echo 'checked'; ?>>
                          <button type="button" class="btn btn-outline-primary w-100 select-pkg-btn" data-target="pkg_pro">
                            <?php echo (isset($package) && $package=='Professional') ? '<i class="bi bi-check2"></i> เลือกแล้ว' : 'เลือกแพ็กเกจนี้'; ?>
                          </button>
                        </div>
                      </div>
                    </div>

                    <!-- Enterprise Package -->
                    <div class="col-lg-4">
                      <div id="card_enterprise" class="package-box p-4 <?php echo (isset($package) && $package=='Enterprise') ? 'selected-package' : ''; ?>">
                        <div>
                          <div class="text-center pb-3 border-bottom mb-3">
                            <span class="badge bg-dark-subtle text-dark px-3 py-1 rounded-pill mb-2">Enterprise</span>
                            <h4 class="fw-bold text-dark mb-1">Enterprise Package</h4>
                            <span class="text-muted small">สำหรับองค์กรขนาดใหญ่</span>
                          </div>
                          <!-- รายละเอียดทางด้านซ้าย -->
                          <ul class="feature-list">
                            <li><i class="bi bi-check-circle-fill text-success"></i> <span>ผู้ใช้งานระบบแบบไม่จำกัด (Unlimited)</span></li>
                            <li><i class="bi bi-check-circle-fill text-success"></i> <span>Competency Framework + ที่ปรึกษาเฉพาะ</span></li>
                            <li><i class="bi bi-check-circle-fill text-success"></i> <span>ประเมินขั้นสูงพร้อมระบบค้นหา Trainer</span></li>
                            <li><i class="bi bi-check-circle-fill text-success"></i> <span>Organization Dashboard & Advanced IDP</span></li>
                            <li><i class="bi bi-check-circle-fill text-success"></i> <span>ผู้ดูแลระบบส่วนตัว (Dedicated Manager)</span></li>
                          </ul>
                        </div>
                        <div class="text-center mt-4 pt-2 border-top">
                          <input class="form-check-input d-none" type="radio" name="package" id="pkg_enterprise" value="Enterprise" <?php if(isset($package) && $package=='Enterprise') echo 'checked'; ?>>
                          <button type="button" class="btn btn-outline-primary w-100 select-pkg-btn" data-target="pkg_enterprise">
                            <?php echo (isset($package) && $package=='Enterprise') ? '<i class="bi bi-check2"></i> เลือกแล้ว' : 'เลือกแพ็กเกจนี้'; ?>
                          </button>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>

                <!-- Submit Button -->
                <div class="col-md-12 text-center mt-5">
                  <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow-sm">
                    <i class="bi bi-check2-circle me-2"></i> ยืนยันการลงทะเบียน (Submit Registration)
                  </button>
                </div>

              </div>

            </form>

          </div>
        </div>
      </div>

    </section><!-- /Registration Section -->

  </main>

  <footer id="footer" class="footer light-background py-4">
    <div class="container">
      <div class="copyright text-center">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">Kelly</strong> <span>All Rights Reserved</span></p>
      </div>
      <div class="social-links d-flex justify-content-center my-3">
        <a href=""><i class="bi bi-twitter-x"></i></a>
        <a href=""><i class="bi bi-facebook"></i></a>
        <a href=""><i class="bi bi-instagram"></i></a>
        <a href=""><i class="bi bi-linkedin"></i></a>
      </div>
      <div class="credits text-center text-muted small">
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

  <!-- Script to handle package selection click -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const selectButtons = document.querySelectorAll(".select-pkg-btn");

      selectButtons.forEach(button => {
        button.addEventListener("click", function() {
          const targetId = this.getAttribute("data-target");
          
          // Check corresponding radio button
          document.getElementById(targetId).checked = true;

          // Remove selected state & update text for all cards/buttons
          document.querySelectorAll(".package-box").forEach(box => {
            box.classList.remove("selected-package");
          });
          document.querySelectorAll(".select-pkg-btn").forEach(btn => {
            btn.classList.remove("btn-primary", "text-white");
            btn.classList.add("btn-outline-primary");
            btn.textContent = "เลือกแพ็กเกจนี้";
          });

          // Add selected state & update text for clicked card/button
          const parentBox = this.closest(".package-box");
          parentBox.classList.add("selected-package");
          this.classList.remove("btn-outline-primary");
          this.classList.add("btn-primary", "text-white");
          this.innerHTML = '<i class="bi bi-check2"></i> เลือกแล้ว';
        });
      });
    });
  </script>

</body>

</html>
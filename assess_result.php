<?php
// ตัวอย่างข้อมูลจำลองสำหรับรายชื่อพนักงาน
$employees = array(
    array("id" => "EMP001", "name" => "สมชาย", "surname" => "ใจดี", "department" => "IT", "position" => "Developer"),
    array("id" => "EMP002", "name" => "สมหญิง", "surname" => "รักเรียน", "department" => "HR", "position" => "HR Officer"),
    array("id" => "EMP003", "name" => "วิชัย", "surname" => "มั่นคง", "department" => "Finance", "position" => "Accountant")
);

// ตัวอย่างข้อมูล Competency พร้อม Requirement, Gain และ Gap (คำนวณจาก Requirement - Gain หรือตามความเหมาะสม)
$competencies = array(
    array(
        "code" => "COMP01",
        "name_th" => "การแก้ไขปัญหาและการตัดสินใจ",
        "name_eng" => "Problem Solving & Decision Making",
        "description" => "ความสามารถในการวิเคราะห์และแก้ไขปัญหาที่ซับซ้อนได้อย่างมีประสิทธิภาพ",
        "requirement" => 4,
        "gain" => 3,
        "gap" => -1
    ),
    array(
        "code" => "COMP02",
        "name_th" => "การทำงานร่วมกันเป็นทีม",
        "name_eng" => "Teamwork & Collaboration",
        "description" => "การทำงานร่วมกับผู้อื่นและการสร้างความสัมพันธ์ที่ดีในทีม",
        "requirement" => 3,
        "gain" => 3,
        "gap" => 0
    ),
    array(
        "code" => "COMP03",
        "name_th" => "ทักษะการสื่อสาร",
        "name_eng" => "Communication Skills",
        "description" => "การถ่ายทอดข้อมูล การเจรจาต่อรอง และการสื่อสารอย่างมีประสิทธิภาพ",
        "requirement" => 4,
        "gain" => 2,
        "gap" => -2
    )
);

// ค่าพนักงานที่ถูกเลือก (จำลองเลือก EMP001 เป็นค่าเริ่มต้น)
$selected_emp_id = $_GET['emp_id'] ?? 'EMP001';
$current_employee = null;
foreach ($employees as $emp) {
    if ($emp['id'] === $selected_emp_id) {
        $current_employee = $emp;
        break;
    }
}
if (!$current_employee) {
    $current_employee = $employees[0];
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
			  <li><a href="dashboard.html">Dashboard</a></li>
			  <li><a href="#">Search for Trainer</a></li>
			</ul>
		   </li>		  
          <li><a href="training_courses.html">Training Courses</a></li>
		  <li class="dropdown"><a href="trainer_menu.html"><span>Trainer Menu</span></a>
			<ul>
				<li><a href="add_courses.php">Add more courses</a></li>
				<li><a href="update_idp.php">Update IDP</a></li>
			</ul>
		  </li>
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

  <div class="container py-5">
    
    <!-- Header Title -->
    <div class="row mb-4">
      <div class="col-md-12 text-center">
        <h2 class="fw-bold text-primary">ผลการประเมิน Competency ของคุณ</h2>
        <p class="text-muted">สรุปผลการประเมินความสามารถและช่องว่างในการพัฒนา (Gap Analysis)</p>
      </div>
    </div>

    <!-- ส่วนแสดงข้อมูลพนักงานผู้เข้าทำการประเมิน (เป็น Label) -->
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title fw-bold mb-3 text-secondary"><i class="bi bi-person-badge me-2"></i>ข้อมูลพนักงานผู้เข้าทำการประเมิน</h5>
        <div class="row g-3">
          <div class="col-md-3">
            <span class="d-block text-muted small">รหัสพนักงาน</span>
            <span class="fs-6 fw-bold text-dark"><?php echo htmlspecialchars($current_employee['id'], ENT_QUOTES, 'UTF-8'); ?></span>
          </div>
          <div class="col-md-3">
            <span class="d-block text-muted small">ชื่อ</span>
            <span class="fs-6 fw-bold text-dark"><?php echo htmlspecialchars($current_employee['name'], ENT_QUOTES, 'UTF-8'); ?></span>
          </div>
          <div class="col-md-3">
            <span class="d-block text-muted small">นามสกุล</span>
            <span class="fs-6 fw-bold text-dark"><?php echo htmlspecialchars($current_employee['surname'], ENT_QUOTES, 'UTF-8'); ?></span>
          </div>
          <div class="col-md-3">
            <span class="d-block text-muted small">แผนก / ตำแหน่ง</span>
            <span class="fs-6 fw-bold text-dark"><?php echo htmlspecialchars($current_employee['department'] . ' / ' . $current_employee['position'], ENT_QUOTES, 'UTF-8'); ?></span>
          </div>
        </div>
      </div>
    </div>

    <!-- ตารางแสดง Competency ID, Name, Description และด้านขวาแสดง Requirement, Gain, Gap -->
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-primary text-white fw-bold">
        <i class="bi bi-table me-2"></i>รายการผลการประเมิน Competency
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-bordered table-hover mb-0">
            <thead class="table-light text-center">
              <tr>
                <th style="width: 10%;">Competency ID</th>
                <th style="width: 25%;">Competency Name</th>
                <th style="width: 35%;">Competency Description</th>
                <th style="width: 10%;">Requirement</th>
                <th style="width: 10%;">Gain</th>
                <th style="width: 10%;">Gap</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($competencies as $comp): ?>
                <tr>
                  <td class="text-center fw-semibold text-primary"><?php echo htmlspecialchars($comp['code'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td>
                    <div class="fw-bold"><?php echo htmlspecialchars($comp['name_th'], ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="text-muted small"><?php echo htmlspecialchars($comp['name_eng'], ENT_QUOTES, 'UTF-8'); ?></div>
                  </td>
                  <td>
                    <span class="text-secondary small"><?php echo htmlspecialchars($comp['description'], ENT_QUOTES, 'UTF-8'); ?></span>
                  </td>
                  <td class="text-center fw-bold"><?php echo $comp['requirement']; ?></td>
                  <td class="text-center fw-bold text-success"><?php echo $comp['gain']; ?></td>
                  <td class="text-center fw-bold <?php echo ($comp['gap'] < 0) ? 'text-danger' : 'text-success'; ?>">
                    <?php echo ($comp['gap'] > 0 ? '+' . $comp['gap'] : $comp['gap']); ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ด้านล่าง: ปุ่มกดเพื่อ Download PDF -->
    <div class="text-center">
      <a href="download_pdf.php?emp_id=<?php echo htmlspecialchars($current_employee['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-danger btn-lg px-5 shadow">
        <i class="bi bi-file-earmark-pdf-fill me-2"></i> Download PDF
      </a>
    </div>

  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
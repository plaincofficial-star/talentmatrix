<?php
// ตัวอย่างข้อมูลจำลองสำหรับรายชื่อพนักงาน พร้อม แผนก และ ตำแหน่ง
$employees = array(
    array("id" => "EMP001", "name" => "สมชาย", "surname" => "ใจดี", "department" => "IT", "position" => "Developer"),
    array("id" => "EMP002", "name" => "สมหญิง", "surname" => "รักเรียน", "department" => "HR", "position" => "HR Officer"),
    array("id" => "EMP003", "name" => "วิชัย", "surname" => "มั่นคง", "department" => "Finance", "position" => "Accountant")
);

// ตัวอย่างข้อมูล Competency พร้อม Description, Category, Type, Levels และ Remark
$competencies = array(
    array(
        "code" => "COMP01",
        "name_th" => "การแก้ไขปัญหาและการตัดสินใจ",
        "name_eng" => "Problem Solving & Decision Making",
        "description" => "ความสามารถในการวิเคราะห์และแก้ไขปัญหาที่ซับซ้อนได้อย่างมีประสิทธิภาพ",
        "category" => "Core",
        "type" => "Skill",
        "remark" => "จำเป็นสำหรับสายงานบริหารและหัวหน้างาน",
        "levels" => array(
            1 => "ระบุปัญหาเบื้องต้นได้",
            2 => "วิเคราะห์สาเหตุและหาทางแก้ได้",
            3 => "ตัดสินใจแก้ปัญหาซับซ้อนได้ดี",
            4 => "วางระบบป้องกันปัญหาล่วงหน้า",
            5 => "เป็นที่ปรึกษาด้านการแก้ปัญหาให้องค์กร"
        )
    ),
    array(
        "code" => "COMP02",
        "name_th" => "การทำงานร่วมกันเป็นทีม",
        "name_eng" => "Teamwork & Collaboration",
        "description" => "การทำงานร่วมกับผู้อื่นและการสร้างความสัมพันธ์ที่ดีในทีม",
        "category" => "Functional",
        "type" => "Attitude",
        "remark" => "ทักษะพื้นฐานสำหรับพนักงานทุกคน",
        "levels" => array(
            1 => "ทำงานร่วมกับผู้อื่นได้ตามสั่ง",
            2 => "ให้ความร่วมมือและช่วยเหลือเพื่อนร่วมทีม",
            3 => "ประสานงานและสร้างบรรยากาศที่ดีในทีม",
            4 => "ประสานความร่วมมือข้ามสายงานได้ดี",
            5 => "สร้างวัฒนธรรมการทำงานเป็นทีมระดับองค์กร"
        )
    ),
    array(
        "code" => "COMP03",
        "name_th" => "ทักษะการสื่อสาร",
        "name_eng" => "Communication Skills",
        "description" => "การถ่ายทอดข้อมูล การเจรจาต่อรอง และการสื่อสารอย่างมีประสิทธิภาพ",
        "category" => "Managerial",
        "type" => "Knowledge",
        "remark" => "เน้นการเจรจาต่อรองระดับสูง",
        "levels" => array(
            1 => "รับสารและสื่อสารเรื่องง่ายๆ ได้",
            2 => "ถ่ายทอดข้อมูลได้ชัดเจนเข้าใจง่าย",
            3 => "เจรจาต่อรองและสื่อสารโน้มน้าวได้ดี",
            4 => "จัดการสื่อสารเชิงกลยุทธ์ในภาวะวิกฤต",
            5 => "เป็นผู้นำการสื่อสารระดับองค์กร"
        )
    )
);

// จัดการข้อมูลจากฟอร์ม (ยังไม่บันทึกลงฐานข้อมูล)
$message = "";
$message_type = "info";
$employee_id = "";
$submitted_gain = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = isset($_POST["action"]) && is_string($_POST["action"]) ? $_POST["action"] : "";
    $employee_id = isset($_POST["assign_emp_id"]) && is_string($_POST["assign_emp_id"])
        ? $_POST["assign_emp_id"] : "";
    $allowed_actions = ["draft", "submit"];

    if (!in_array($action, $allowed_actions, true)) {$message = "คำสั่งไม่ถูกต้อง กรุณาลองใหม่";
        $message_type = "danger";
    } else {
        $valid_employee_ids = array_column($employees, "id");

        if (!in_array($employee_id, $valid_employee_ids, true)) {$message = "กรุณาเลือกรหัสพนักงานที่ถูกต้อง";
            $message_type = "danger";
        } else {
            $gain = $_POST["gain"] ?? [];
            $validation_errors = [];

            if (!is_array($gain)) {
                $validation_errors[] = "รูปแบบคะแนนไม่ถูกต้อง";
            } else {
                foreach ($competencies as $comp) {
                    $code = $comp["code"];
                    $raw_value = $gain[$code] ?? "";

                    // ป้องกันค่าที่ไม่ใช่ข้อความ เช่น ส่งค่าเป็น array เข้ามา
                    if (!is_string($raw_value) && !is_int($raw_value)) {
                        $validation_errors[] = "รูปแบบคะแนนไม่ถูกต้อง";
                        continue;
                    }

                    $raw_value = trim((string) $raw_value);
                    $submitted_gain[$code] = $raw_value;

                    // Draft อนุญาตให้เว้นว่างได้ แต่ Submit ต้องกรอกครบ
                    if ($action === "submit" && $raw_value === "") {
                        $validation_errors[] = "กรุณากรอก Gain ให้ครบทุก Competency";
                        continue;
                    }

                    // รับเฉพาะเลขจำนวนเต็ม 1 ถึง 5 ไม่รับทศนิยมหรือข้อความปน
                    if ($raw_value !== "" && !preg_match('/^[1-5]$/', $raw_value)) {
                        $validation_errors[] = "คะแนน Gain ต้องเป็นจำนวนเต็มระหว่าง 1 ถึง 5";
                    }
                }
            }

            if ($validation_errors) {$message = implode(" ", array_unique($validation_errors));$message_type = "danger";
            } else {
                $message = ($action === "draft")
                    ? "ตรวจสอบข้อมูลแบบร่างเรียบร้อยแล้ว แต่ยังไม่ได้บันทึกถาวร"
                    : "ตรวจสอบข้อมูลแบบประเมินเรียบร้อยแล้ว แต่ยังไม่ได้บันทึกหรือส่งเข้าระบบ";
                $message_type = "warning";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>ประเมินตนเอง (Assess Yourself)</title>
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
  <style>
    .breadcrumbs {
      background-color: #f8f9fa;
      padding: 15px 0;
      margin-bottom: 20px;
      border-bottom: 1px solid #dee2e6;
      border-top: 1px solid #dee2e6;
    }
    .breadcrumbs ol {
      display: flex;
      flex-wrap: wrap;
      list-style: none;
      margin: 0;
      padding: 0;
      font-size: 0.95rem;
    }
    .breadcrumbs ol li + li {
      padding-left: 10px;
    }
    .breadcrumbs ol li + li::before {
      display: inline-block;
      padding-right: 10px;
      color: #6c757d;
      content: "/";
    }
    .breadcrumbs ol li a {
      color: #0d6efd;
      text-decoration: none;
    }
    .breadcrumbs ol li a:hover {
      text-decoration: underline;
    }
    .breadcrumbs ol li.current {
      color: #6c757d;
    }
    .staff-competency-table { min-width: 1400px; table-layout: auto; }
    .staff-competency-table th, .staff-competency-table td { vertical-align: middle; white-space: normal; overflow-wrap: anywhere; }
    .level-definition { display: block; white-space: normal; overflow-wrap: anywhere; line-height: 1.45; }
  </style>
</head>

<body class="about-page">

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
                  <li><a href="#" class="active">Assess Yourself</a></li>
                  <li><a href="#">Search for Trainer</a></li>
				  <li><a href="#">Organization Dashboard</a></li>
                </ul>
              </li>
			
			  <li class="dropdown"><a href="#"><span>Result</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
				  <li><a href="assess_result.php">See your assessment result</a></li>
				  <li><a href="#">See your IDP</a></li>
				</ul>
			  </li>
			  <li><a href="dashboard.html">Dashboard</a></li>
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

    <!-- Breadcrumbs -->
    <nav class="breadcrumbs">
      <div class="container-fluid px-4">
        <ol>
          <li><a href="company_main.html">Main Menu</a></li>
          <li class="current">ประเมินตนเอง (Assess Yourself)</li>
        </ol>
      </div>
    </nav><!-- End Breadcrumbs -->

    <!-- Assess Yourself Section -->
    <section id="about" class="about section pt-0">
      <div class="container section-title" data-aos="fade-up">
        <h2>ประเมินตนเอง (Assess Yourself)</h2>
        <p>ทำการประเมินความสามารถตามโครงสร้าง Competency ที่กำหนด</p>
      </div><!-- End Section Title -->
	 
      <div class="container-fluid px-4" data-aos="fade-up" data-aos-delay="100">
        
        <?php if ($message !== ""): ?>
          <div class="alert alert-<?php echo htmlspecialchars($message_type, ENT_QUOTES, "UTF-8"); ?> alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($message, ENT_QUOTES, "UTF-8"); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
          
          <!-- ส่วนเลือกพนักงานและแสดงชื่อ-นามสกุล -->
          <div class="card shadow-sm mb-4">
            <div class="card-body">
              <h5 class="card-title fw-bold mb-3"><i class="bi bi-person-badge me-2"></i>ข้อมูลพนักงานผู้เข้าทำการประเมิน</h5>
              <div class="row g-3 align-items-center">
                <!-- เลือกรหัสพนักงาน -->
                <div class="col-md-4">
                  <label for="select_emp_id" class="form-label fw-bold">รหัสพนักงาน</label>
                  <select class="form-select" id="select_emp_id" name="assign_emp_id" required>
                    <option value="">-- กรุณาเลือกรหัสพนักงาน --</option>
                    <?php foreach ($employees as$emp): ?>
                      <option value="<?php echo htmlspecialchars($emp['id'], ENT_QUOTES, 'UTF-8'); ?>"
                        <?php echo $employee_id === $emp['id'] ? 'selected' : ''; ?>
                        data-name="<?php echo htmlspecialchars($emp['name'], ENT_QUOTES, 'UTF-8'); ?>" 
                        data-surname="<?php echo htmlspecialchars($emp['surname'], ENT_QUOTES, 'UTF-8'); ?>" 
                        data-dept="<?php echo htmlspecialchars($emp['department'], ENT_QUOTES, 'UTF-8'); ?>" 
                        data-pos="<?php echo htmlspecialchars($emp['position'], ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($emp['id'] . ' - ' . $emp['name'] . ' ' . $emp['surname'], ENT_QUOTES, 'UTF-8'); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <!-- แสดงข้อมูลพนักงาน (ชื่อ, นามสกุล, แผนก, ตำแหน่ง) -->
                <div class="col-md-5">
                  <label class="form-label fw-bold">ชื่อและนามสกุลพนักงาน</label>
                  <div class="form-control bg-light text-dark fw-semibold" id="emp_info_display" style="min-height: 38px;">
                    <span class="text-muted fw-normal">โปรดเลือกรหัสพนักงานเพื่อแสดงข้อมูล...</span>
                  </div>
                </div>

                <!-- อัปโหลดไฟล์เพิ่มเติม -->
                <div class="col-md-3">
                  <label for="upload_file" class="form-label fw-bold">Upload File (ถ้ามี)</label>
                  <input class="form-control" type="file" id="upload_file" name="assign_file" disabled title="ยังไม่ได้เปิดใช้การอัปโหลดไฟล์"><small class="text-muted">ยังไม่เปิดใช้การอัปโหลดไฟล์ในเวอร์ชันนี้</small>
                </div>
              </div>
            </div>
          </div>

          <!-- ตาราง Competency -->
          <div class="card shadow-sm mb-3">
            <div class="card-header bg-light fw-bold">
              <i class="bi bi-table me-2"></i>รายการ Competency และระดับการประเมิน
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0 staff-competency-table" style="font-size: 0.85rem;">
                  <thead class="table-light text-center">
                    <tr>
                      <th style="width: 5%;">ID</th>
                      <th style="width: 15%;">Competency Name</th>
                      <?php for ($lvl = 1; $lvl <= 5; $lvl++): ?>
                        <th style="width: 13%;">Level <?php echo $lvl; ?></th>
                      <?php endfor; ?>
                      <th style="width: 8%;">Gain</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($competencies as$comp): ?>
                      <tr>
                        <td class="text-center fw-semibold"><?php echo htmlspecialchars($comp['code'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="fw-bold">
                          <?php echo htmlspecialchars($comp['name_th'], ENT_QUOTES, 'UTF-8'); ?>
                          <div class="text-muted small"><?php echo htmlspecialchars($comp['name_eng'], ENT_QUOTES, 'UTF-8'); ?></div>
                        </td>
                        <?php for ($lvl = 1; $lvl <= 5; $lvl++): ?>
                          <td>
                            <span class="level-definition" style="font-size: 0.8rem;"><?php echo htmlspecialchars($comp['levels'][$lvl], ENT_QUOTES, 'UTF-8'); ?></span>
                          </td>
                        <?php endfor; ?>
                        <!-- คอลัมน์ Gain (Text Box Input) -->
                        <td class="text-center">
                          <input type="text" class="form-control form-control-sm text-center fw-bold" 
                                 name="gain[<?php echo htmlspecialchars($comp['code'], ENT_QUOTES, 'UTF-8'); ?>]"
                                 inputmode="numeric" pattern="[1-5]" maxlength="1"
                                 aria-label="คะแนน Gain สำหรับ <?php echo htmlspecialchars($comp['name_th'], ENT_QUOTES, 'UTF-8'); ?>"
                                 value="<?php echo htmlspecialchars($submitted_gain[$comp['code']] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                 placeholder="1-5" style="max-width: 70px; margin: 0 auto;">
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- ปุ่ม Save as draft และ Submit ด้านล่างสุด -->
          <div class="text-end mb-4">
            <button type="submit" name="action" value="draft" class="btn btn-secondary px-4 py-2 me-2">
              <i class="bi bi-file-earmark-text me-1"></i> Save as draft
            </button>
            <button type="submit" name="action" value="submit" class="btn btn-success px-4 py-2">
              <i class="bi bi-send-check me-1"></i> Submit
            </button>
          </div>

        </form>

      </div>
     
    </section><!-- /About Section -->

  </main>

  <footer id="footer" class="footer light-background">

    <div class="container">
      <div class="copyright text-center ">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">PLAI Inc.</strong> <span>All Rights Reserved<br></span></p>
      </div>
      <div class="social-links d-flex justify-content-center">
        <a href=""><i class="bi bi-twitter-x"></i></a>
        <a href=""><i class="bi bi-facebook"></i></a>
        <a href=""><i class="bi bi-instagram"></i></a>
        <a href=""><i class="bi bi-linkedin"></i></a>
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://bootstrapmade.com/">PLAI Inc.</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
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
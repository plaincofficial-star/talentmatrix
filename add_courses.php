<?php
declare(strict_types=1);

session_start();

$message = '';
$alert_type = 'info';
$image_uploaded = '';

function e($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company_code = trim((string)($_POST['company_code'] ?? ''));
    $company_name = trim((string)($_POST['company_name'] ?? ''));
    $trainer_name = trim((string)($_POST['trainer_name'] ?? ''));
    $course_name = trim((string)($_POST['course_name'] ?? ''));
    $category = trim((string)($_POST['category'] ?? ''));
    $type = trim((string)($_POST['type'] ?? ''));
    $course_desc = trim((string)($_POST['course_desc'] ?? ''));
    $remarks = trim((string)($_POST['remarks'] ?? ''));
    $competencies = $_POST['competencies'] ?? [];

    $allowedCategories = ['core', 'functional', 'managerial'];
    $allowedTypes = ['skill', 'attitude', 'knowledge'];
    $allowedCompetencies = [
        'Communication', 'Leadership', 'Problem Solving',
        'Teamwork', 'Strategic Thinking', 'Customer Focus'
    ];

    if (!is_array($competencies)) {
        $competencies = [];
    }
    $competencies = array_values(array_unique(array_filter(
        array_map(static fn($v) => is_string($v) ? trim($v) : '', $competencies),
        static fn($v) => in_array($v, $allowedCompetencies, true)
    )));

    $errors = [];
    if ($company_code === '' || $company_name === '' || $trainer_name === '' || $course_name === '') {
        $errors[] = 'กรุณากรอกข้อมูลบริษัท ผู้ติดต่อ และชื่อหลักสูตรให้ครบถ้วน';
    }
    if (!in_array($category, $allowedCategories, true)) {
        $errors[] = 'กรุณาเลือก Category ให้ถูกต้อง';
    }
    if (!in_array($type, $allowedTypes, true)) {
        $errors[] = 'กรุณาเลือก Type ให้ถูกต้อง';
    }

    $uploadDir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads';
    if (!$errors && isset($_FILES['course_image']) && $_FILES['course_image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['course_image'];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'อัปโหลดรูปภาพไม่สำเร็จ (รหัสข้อผิดพลาด ' . (int)$file['error'] . ')';
        } elseif ((int)$file['size'] > 5 * 1024 * 1024) {
            $errors[] = 'รูปภาพต้องมีขนาดไม่เกิน 5 MB';
        } elseif (!is_uploaded_file($file['tmp_name'])) {
            $errors[] = 'ไฟล์อัปโหลดไม่ถูกต้อง';
        } else {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($file['tmp_name']);
            $allowedMimes = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'image/webp' => 'webp'
            ];
            if (!isset($allowedMimes[$mime]) || @getimagesize($file['tmp_name']) === false) {
                $errors[] = 'รองรับเฉพาะไฟล์ภาพ JPG, PNG, GIF หรือ WEBP';
            } elseif (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
                $errors[] = 'ไม่สามารถสร้างโฟลเดอร์ uploads ได้';
            } else {
                $newFilename = 'course_' . bin2hex(random_bytes(12)) . '.' . $allowedMimes[$mime];
                $destination = $uploadDir . DIRECTORY_SEPARATOR . $newFilename;
                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $image_uploaded = 'uploads/' . $newFilename;
                } else {
                    $errors[] = 'ไม่สามารถบันทึกไฟล์รูปภาพได้';
                }
            }
        }
    }

    if (!$errors) {
        // บันทึกข้อมูลลงไฟล์ JSON สำหรับใช้งาน/ทดสอบบน localhost โดยไม่ต้องมีฐานข้อมูล
        $dataDir = __DIR__ . DIRECTORY_SEPARATOR . 'data';
        $dataFile = $dataDir . DIRECTORY_SEPARATOR . 'courses.json';
        if (!is_dir($dataDir) && !mkdir($dataDir, 0755, true) && !is_dir($dataDir)) {
            $errors[] = 'ไม่สามารถสร้างโฟลเดอร์ data ได้';
        } else {
            $records = [];
            if (is_file($dataFile)) {
                $existing = file_get_contents($dataFile);
                $decoded = $existing !== false ? json_decode($existing, true) : null;
                if (is_array($decoded)) {
                    $records = $decoded;
                } elseif (trim((string)$existing) !== '') {
                    $errors[] = 'ไฟล์ข้อมูลเดิมเสียหาย กรุณาตรวจสอบ data/courses.json';
                }
            }
            if (!$errors) {
                $records[] = [
                    'id' => bin2hex(random_bytes(8)),
                    'created_at' => date(DATE_ATOM),
                    'company_code' => $company_code,
                    'company_name' => $company_name,
                    'trainer_name' => $trainer_name,
                    'course_name' => $course_name,
                    'category' => $category,
                    'type' => $type,
                    'competencies' => $competencies,
                    'course_desc' => $course_desc,
                    'remarks' => $remarks,
                    'image' => $image_uploaded
                ];
                $json = json_encode($records, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                if ($json === false || file_put_contents($dataFile, $json . PHP_EOL, LOCK_EX) === false) {
                    $errors[] = 'บันทึกข้อมูลไม่ได้ กรุณาตรวจสอบสิทธิ์เขียนไฟล์ของโฟลเดอร์ data';
                }
            }
        }
    }

    if ($errors) {
        // หากบันทึกไม่สำเร็จและอัปโหลดภาพไปแล้ว ให้ลบภาพที่เพิ่งอัปโหลด
        if ($image_uploaded !== '' && is_file(__DIR__ . DIRECTORY_SEPARATOR . $image_uploaded)) {
            @unlink(__DIR__ . DIRECTORY_SEPARATOR . $image_uploaded);
            $image_uploaded = '';
        }
        $message = implode(' ', $errors);
        $alert_type = 'danger';
    } else {
        $message = "บันทึกหลักสูตร “" . $course_name . "” ของบริษัท " . $company_name . " สำเร็จแล้ว";
        $alert_type = 'success';
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>TalentMatrix - Add more training courses</title>
  <meta name="description" content="Add more training courses">
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
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center light-background sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename">TalentMatrix</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.html">Home</a></li>  
		  <li class="dropdown"><a href="company_main.html"><span>Main Menu</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
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
		  <li class="dropdown"><a href="trainer_menu.html" class="active"><span>Trainer Menu</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
			<ul>
				<li><a href="add_courses.php" class="active">Add more courses</a></li>
				<li><a href="update_idp.php">Update IDP</a></li>
			</ul>
		  </li>
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

    <!-- Add Courses Section -->
    <section id="starter-section" class="starter-section section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Add more training courses</h2>
        <p>กรอกข้อมูลรายละเอียดหลักสูตรการฝึกอบรม ข้อมูลบริษัท และคุณลักษณะ Competency ที่เกี่ยวข้อง</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up">
        
        <?php if ($message !== ''): ?>
          <div class="alert alert-<?php echo e($alert_type); ?> alert-dismissible fade show" role="alert">
            <?php echo e($message); ?>
            <?php if ($image_uploaded !== ''): ?>
              <br><small>อัปโหลดรูปภาพสำเร็จ: <?php echo e($image_uploaded); ?></small>
            <?php endif; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <!-- Form เริ่มต้น -->
        <form action="add_courses.php" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
          
          <div class="row g-3">
            <!-- 3. รหัสบริษัท , ชื่อบริษัท , ชื่อ -->
            <div class="col-md-4">
              <label for="company_code" class="form-label fw-bold">รหัสบริษัท (Company Code)</label>
              <input type="text" class="form-control" id="company_code" name="company_code" placeholder="เช่น C001" required>
            </div>
            <div class="col-md-4">
              <label for="company_name" class="form-label fw-bold">ชื่อบริษัท (Company Name)</label>
              <input type="text" class="form-control" id="company_name" name="company_name" placeholder="ระบุชื่อบริษัท" required>
            </div>
            <div class="col-md-4">
              <label for="trainer_name" class="form-label fw-bold">ชื่อผู้สอน / ผู้ติดต่อ (Name)</label>
              <input type="text" class="form-control" id="trainer_name" name="trainer_name" placeholder="ระบุชื่อ-นามสกุล" required>
            </div>

            <!-- ชื่อหลักสูตร -->
            <div class="col-12">
              <label for="course_name" class="form-label fw-bold">ชื่อหลักสูตรการฝึกอบรม (Course Name)</label>
              <input type="text" class="form-control" id="course_name" name="course_name" placeholder="ระบุชื่อหลักสูตร" required>
            </div>

            <!-- 7. Drop down list เลือก Category -->
            <div class="col-md-6">
              <label for="category" class="form-label fw-bold">Category</label>
              <select class="form-select" id="category" name="category" required>
                <option value="" selected disabled>-- เลือก Category --</option>
                <option value="core">Core</option>
                <option value="functional">Functional</option>
                <option value="managerial">Managerial</option>
              </select>
            </div>

            <!-- 8. Drop down list เลือก Type -->
            <div class="col-md-6">
              <label for="type" class="form-label fw-bold">Type</label>
              <select class="form-select" id="type" name="type" required>
                <option value="" selected disabled>-- เลือก Type --</option>
                <option value="skill">Skill</option>
                <option value="attitude">Attitude</option>
                <option value="knowledge">Knowledge</option>
              </select>
            </div>

            <!-- 6. Drop down list เลือก Competency และปุ่ม Add -->
            <div class="col-md-8">
              <label for="competency_select" class="form-label fw-bold">Select Competency</label>
              <select class="form-select" id="competency_select">
                <option value="" selected disabled>-- เลือก Competency เพื่อเพิ่ม --</option>
                <option value="Communication">Communication</option>
                <option value="Leadership">Leadership</option>
                <option value="Problem Solving">Problem Solving</option>
                <option value="Teamwork">Teamwork</option>
                <option value="Strategic Thinking">Strategic Thinking</option>
                <option value="Customer Focus">Customer Focus</option>
              </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
              <button type="button" class="btn btn-secondary w-100" id="addCompetencyBtn">
                <i class="bi bi-plus-circle"></i> Add Competency
              </button>
            </div>

            <!-- แสดง Competency ที่เลือกไว้ทั้งหมด -->
            <div class="col-12">
              <label class="form-label fw-bold">Competency ที่เลือกไว้ทั้งหมด:</label>
              <div id="selectedCompetenciesContainer" class="p-3 border rounded bg-light" style="min-height: 60px;">
                <span class="text-muted" id="noCompetencyText">ยังไม่ได้เลือก Competency ใดๆ</span>
              </div>
            </div>

            <!-- 5. Text box อธิบายเนื้อหาหลักสูตร -->
            <div class="col-12">
              <label for="course_desc" class="form-label fw-bold">รายละเอียดเนื้อหาหลักสูตร (Course Description)</label>
              <textarea class="form-control" id="course_desc" name="course_desc" rows="4" placeholder="กรอกรายละเอียด วัตถุประสงค์ หรือเนื้อหาย่อยของหลักสูตร..."></textarea>
            </div>

            <!-- 4. ปุ่ม Upload Image -->
            <div class="col-12">
              <label for="course_image" class="form-label fw-bold">อัปโหลดรูปภาพ (Upload Image)</label>
              <input class="form-control" type="file" id="course_image" name="course_image" accept="image/*">
            </div>

            <!-- 9. ช่อง หมายเหตุ -->
            <div class="col-12">
              <label for="remarks" class="form-label fw-bold">หมายเหตุ (Remarks)</label>
              <textarea class="form-control" id="remarks" name="remarks" rows="2" placeholder="ระบุข้อมูลเพิ่มเติม (ถ้ามี)..."></textarea>
            </div>

            <!-- ปุ่มบันทึก -->
            <div class="col-12 text-center mt-4">
              <button type="submit" class="btn btn-primary px-5 py-2">บันทึกข้อมูลหลักสูตร</button>
            </div>

          </div>

        </form>

      </div>

    </section><!-- /Add Courses Section -->

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

  <!-- Script สำหรับระบบเพิ่ม/ลบ Competency รายการแบบไดนามิก -->
  <script>
    (function () {
      const select = document.getElementById('competency_select');
      const addButton = document.getElementById('addCompetencyBtn');
      const container = document.getElementById('selectedCompetenciesContainer');

      function refreshEmptyState() {
        const hasItems = container.querySelectorAll('input[name="competencies[]"]').length > 0;
        const emptyText = document.getElementById('noCompetencyText');
        if (!hasItems && !emptyText) {
          const span = document.createElement('span');
          span.className = 'text-muted';
          span.id = 'noCompetencyText';
          span.textContent = 'ยังไม่ได้เลือก Competency ใดๆ';
          container.appendChild(span);
        } else if (hasItems && emptyText) {
          emptyText.remove();
        }
      }

      addButton.addEventListener('click', function () {
        const value = select.value;
        if (!value) {
          alert('กรุณาเลือก Competency ก่อนกดปุ่ม Add');
          return;
        }
        if (Array.from(container.querySelectorAll('input[name="competencies[]"]'))
          .some(input => input.value === value)) {
          alert('คุณได้เลือก Competency นี้ไปแล้ว');
          return;
        }

        const emptyText = document.getElementById('noCompetencyText');
        if (emptyText) emptyText.remove();

        const badge = document.createElement('span');
        badge.className = 'badge bg-primary me-2 mb-2 p-2 fs-6 d-inline-flex align-items-center';

        const label = document.createElement('span');
        label.textContent = select.options[select.selectedIndex].text;
        badge.appendChild(label);

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn-close btn-close-white btn-sm ms-2';
        removeButton.setAttribute('aria-label', 'Remove');
        removeButton.addEventListener('click', function () {
          badge.remove();
          refreshEmptyState();
        });
        badge.appendChild(removeButton);

        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'competencies[]';
        hidden.value = value;
        badge.appendChild(hidden);

        container.appendChild(badge);
        select.selectedIndex = 0;
      });
    })();
  </script>

</body>

</html>
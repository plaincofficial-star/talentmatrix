<?php
// ตัวอย่างข้อมูลจำลองสำหรับรายชื่อพนักงาน พร้อม แผนก และ ตำแหน่ง
$employees = [
    ["id" => "EMP001", "name" => "สมชาย", "surname" => "ใจดี", "department" => "IT", "position" => "Developer"],
    ["id" => "EMP002", "name" => "สมหญิง", "surname" => "รักเรียน", "department" => "HR", "position" => "HR Officer"],
    ["id" => "EMP003", "name" => "วิชัย", "surname" => "มั่นคง", "department" => "Finance", "position" => "Accountant"]
];

// ตัวอย่างข้อมูล Competency พร้อม Description, Category, Type, Levels และหมายเหตุ
$competencies = [
    [
        "code" => "COMP01",
        "name_th" => "การแก้ไขปัญหาและการตัดสินใจ",
        "name_eng" => "Problem Solving & Decision Making",
        "description" => "ความสามารถในการวิเคราะห์และแก้ไขปัญหาที่ซับซ้อนได้อย่างมีประสิทธิภาพ",
        "category" => "Core",
        "type" => "Skill",
        "remark" => "จำเป็นสำหรับสายงานบริหารและหัวหน้างาน",
        "levels" => [
            1 => "ระบุปัญหาเบื้องต้นได้",
            2 => "วิเคราะห์สาเหตุและหาทางแก้ได้",
            3 => "ตัดสินใจแก้ปัญหาซับซ้อนได้ดี",
            4 => "วางระบบป้องกันปัญหาล่วงหน้า",
            5 => "เป็นที่ปรึกษาด้านการแก้ปัญหาให้องค์กร"
        ]
    ],
    [
        "code" => "COMP02",
        "name_th" => "การทำงานร่วมกันเป็นทีม",
        "name_eng" => "Teamwork & Collaboration",
        "description" => "การทำงานร่วมกับผู้อื่นและการสร้างความสัมพันธ์ที่ดีในทีม",
        "category" => "Functional",
        "type" => "Attitude",
        "remark" => "ทักษะพื้นฐานสำหรับพนักงานทุกคน",
        "levels" => [
            1 => "ทำงานร่วมกับผู้อื่นได้ตามสั่ง",
            2 => "ให้ความร่วมมือและช่วยเหลือเพื่อนร่วมทีม",
            3 => "ประสานงานและสร้างบรรยากาศที่ดีในทีม",
            4 => "ประสานความร่วมมือข้ามสายงานได้ดี",
            5 => "สร้างวัฒนธรรมการทำงานเป็นทีมระดับองค์กร"
        ]
    ],
    [
        "code" => "COMP03",
        "name_th" => "ทักษะการสื่อสาร",
        "name_eng" => "Communication Skills",
        "description" => "การถ่ายทอดข้อมูล การเจรจาต่อรอง และการสื่อสารอย่างมีประสิทธิภาพ",
        "category" => "Managerial",
        "type" => "Knowledge",
        "remark" => "เน้นการเจรจาต่อรองระดับสูง",
        "levels" => [
            1 => "รับสารและสื่อสารเรื่องง่ายๆ ได้",
            2 => "ถ่ายทอดข้อมูลได้ชัดเจนเข้าใจง่าย",
            3 => "เจรจาต่อรองและสื่อสารโน้มน้าวได้ดี",
            4 => "จัดการสื่อสารเชิงกลยุทธ์ในภาวะวิกฤต",
            5 => "เป็นผู้นำการสื่อสารระดับองค์กร"
        ]
    ]
];

// ตรวจสอบเมื่อมีการกดปุ่ม Save (POST Request)
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>ได้รับข้อมูลจากฟอร์มแล้ว</strong> ไฟล์ตัวอย่างนี้ยังไม่ได้เชื่อมต่อฐานข้อมูล จึงยังไม่สามารถยืนยันการบันทึกถาวรได้
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'; 
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Competency Framework</title>
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
    /* แต่งแถบ Breadcrumbs ให้เป็นแถบสียาวเต็มหน้าจอ */
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
    .staff-competency-table { min-width: 1500px; table-layout: auto; }
    .staff-competency-table th, .staff-competency-table td { vertical-align: top; white-space: normal; overflow-wrap: anywhere; }
    .level-definition { display: block; white-space: normal; overflow-wrap: anywhere; line-height: 1.45; margin-bottom: .5rem; min-width: 180px; }
    .level-definition-label { font-weight: 600; color: #495057; }
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
                  <li><a href="assess_yourself.php">Assess Yourself</a></li>
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

    <!-- Breadcrumbs -->
    <nav class="breadcrumbs">
      <div class="container-fluid px-4">
        <ol>
          <li><a href="company_main.html">Main Menu</a></li>
          <li class="current">Develop Competency Framework for Your Organization</li>
        </ol>
      </div>
    </nav><!-- End Breadcrumbs -->

    <!-- Assess Your Team Section -->
    <section id="about" class="about section pt-0">
      <div class="container section-title" data-aos="fade-up">
        <h2>Develop Competency Framework for Your Organization</h2>
        <p>Search from our competencies to match your requirements.</p>
      </div><!-- End Section Title -->
	 
      <div class="container-fluid px-4" data-aos="fade-up" data-aos-delay="100">
        
        <?php echo $message; ?>

        <form action="" method="POST" enctype="multipart/form-data">
          
          <!-- Bootstrap Nav Tabs -->
          <ul class="nav nav-tabs mb-4" id="competencyTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active fw-bold" id="browse-tab" data-bs-toggle="tab" data-bs-target="#browse-tab-pane" type="button" role="tab" aria-controls="browse-tab-pane" aria-selected="true">
                <i class="bi bi-search me-1"></i> Browse & Select Competency
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link fw-bold" id="list-tab" data-bs-toggle="tab" data-bs-target="#list-tab-pane" type="button" role="tab" aria-controls="list-tab-pane" aria-selected="false">
                <i class="bi bi-list-check me-1"></i> Your Competency List
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link fw-bold" id="assign-tab" data-bs-toggle="tab" data-bs-target="#assign-tab-pane" type="button" role="tab" aria-controls="assign-tab-pane" aria-selected="false">
                <i class="bi bi-person-plus me-1"></i> Assign Competency to Staff
              </button>
            </li>
          </ul>

          <!-- Tab Content -->
          <div class="tab-content" id="competencyTabsContent">		  
		          
            <!-- Tab 1: Browse & Select Competency -->
            <div class="tab-pane fade show active" id="browse-tab-pane" role="tabpanel" aria-labelledby="browse-tab" tabindex="0">
			
			<!-- ช่องค้นหาข้อมูล competency -->
          <div class="row mb-4 justify-content-center">
            <div class="col-md-6 text-center">
              <label for="employee_search" class="form-label fw-bold">Search competency</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input class="form-control" list="competencyOptions" id="employee_search" name="employee_search" placeholder="Type to search competency">
                <input type="hidden" id="employee_id" name="searched_competency_code">
              </div>
              <datalist id="competencyOptions">
                <?php foreach ($competencies as $comp): ?>
                  <option data-id="<?php echo htmlspecialchars($comp['code'], ENT_QUOTES, 'UTF-8'); ?>" value="<?php echo htmlspecialchars($comp['name_th'] . ' (' . $comp['name_eng'] . ')', ENT_QUOTES, 'UTF-8'); ?>"></option>
                <?php endforeach; ?>
              </datalist>
            </div>
          </div>
			
              <div class="table-responsive mb-3">
                <table class="table table-bordered table-hover align-middle" style="font-size: 0.9rem;">
                  <thead class="table-light text-center">
                    <tr>
                      <th style="width: 3%;">Select</th>
                      <th style="width: 8%;">ID</th>
                      <th style="width: 12%;">Competency (TH)</th>
                      <th style="width: 12%;">Competency (ENG)</th>
                      <th style="width: 15%;">Description</th>
                      <th style="width: 8%;">Category</th>
                      <th style="width: 8%;">Type</th>
                      <th style="width: 7%;">Level 1</th>
                      <th style="width: 7%;">Level 2</th>
                      <th style="width: 7%;">Level 3</th>
                      <th style="width: 7%;">Level 4</th>
                      <th style="width: 6%;">Level 5</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($competencies as $index => $comp): ?>
                      <tr>
                        <td class="text-center">
                          <input class="form-check-input" type="checkbox" name="selected_comps[]" value="<?php echo $comp['code']; ?>">
                        </td>
                        <td class="text-center fw-semibold text-secondary"><?php echo $comp['code']; ?></td>
                        <td class="fw-bold">
                          <?php echo $comp['name_th']; ?>
                          <input type="hidden" name="competency_code[<?php echo $index; ?>]" value="<?php echo $comp['code']; ?>">
                        </td>
                        <td><?php echo $comp['name_eng']; ?></td>
                        <td><?php echo $comp['description']; ?></td>
                        <td><?php echo $comp['category']; ?></td>
                        <td><?php echo $comp['type']; ?></td>
                        <?php for ($lvl = 1; $lvl <= 5; $lvl++): ?>
                          <td>
                            <span class="small text-muted">
                              <?php echo $comp['levels'][$lvl]; ?>
                            </span>
                          </td>
                        <?php endfor; ?>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>

              <!-- ปุ่ม Add to your list -->
              <div class="text-end">
                <button type="button" class="btn btn-secondary px-4 py-2">
                  <i class="bi bi-plus-circle me-1"></i> Add to your list
                </button>
              </div>
            </div>

            <!-- Tab 2: Your Competency List -->
            <div class="tab-pane fade" id="list-tab-pane" role="tabpanel" aria-labelledby="list-tab" tabindex="0">
              <div class="table-responsive mb-3">
                <table class="table table-bordered table-hover align-middle" style="font-size: 0.9rem;">
                  <thead class="table-light text-center">
                    <tr>
                      <th style="width: 4%;">ลำดับ</th>
                      <th style="width: 8%;">ID</th>
                      <th style="width: 12%;">Competency (TH)</th>
                      <th style="width: 12%;">Competency (ENG)</th>
                      <th style="width: 14%;">Description</th>
                      <th style="width: 7%;">Category</th>
                      <th style="width: 7%;">Type</th>
                      <th style="width: 5%;">Level 1</th>
                      <th style="width: 5%;">Level 2</th>
                      <th style="width: 5%;">Level 3</th>
                      <th style="width: 5%;">Level 4</th>
                      <th style="width: 5%;">Level 5</th>
                      <th style="width: 7%;">หมายเหตุ</th>
                      <th style="width: 6%;">จัดการ</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($competencies as $index => $comp): ?>
                      <tr>
                        <td class="text-center"><?php echo ($index + 1); ?></td>
                        <td class="text-center fw-semibold text-secondary"><?php echo $comp['code']; ?></td>
                        <td class="fw-bold"><?php echo $comp['name_th']; ?></td>
                        <td><?php echo $comp['name_eng']; ?></td>
                        <td><?php echo $comp['description']; ?></td>
                        <td><?php echo $comp['category']; ?></td>
                        <td><?php echo $comp['type']; ?></td>
                        <?php for ($lvl = 1; $lvl <= 5; $lvl++): ?>
                          <td>
                            <span class="small text-muted">
                              <?php echo $comp['levels'][$lvl]; ?>
                            </span>
                          </td>
                        <?php endfor; ?>
                        <!-- ช่องหมายเหตุแสดงเป็นข้อความ Text ธรรมดา -->
                        <td>
                          <span class="small text-secondary">
                            <?php echo $comp['remark']; ?>
                          </span>
                        </td>
                        <td class="text-center">
                          <!-- ปุ่มคลิกเปิด Modal แก้ไขข้อมูลประจำแถว -->
                          <button type="button" class="btn btn-warning btn-sm btn-edit" title="แก้ไขข้อมูล"
                            data-bs-toggle="modal" 
                            data-bs-target="#editModal"
                            data-th="<?php echo htmlspecialchars($comp['name_th']); ?>"
                            data-eng="<?php echo htmlspecialchars($comp['name_eng']); ?>"
                            data-desc="<?php echo htmlspecialchars($comp['description']); ?>"
                            data-category="<?php echo htmlspecialchars($comp['category']); ?>"
                            data-type="<?php echo htmlspecialchars($comp['type']); ?>"
                            data-lvl1="<?php echo htmlspecialchars($comp['levels'][1]); ?>"
                            data-lvl2="<?php echo htmlspecialchars($comp['levels'][2]); ?>"
                            data-lvl3="<?php echo htmlspecialchars($comp['levels'][3]); ?>"
                            data-lvl4="<?php echo htmlspecialchars($comp['levels'][4]); ?>"
                            data-lvl5="<?php echo htmlspecialchars($comp['levels'][5]); ?>"
                            data-remark="<?php echo htmlspecialchars($comp['remark']); ?>">
                            <i class="bi bi-pencil-square"></i>
                          </button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>

              <!-- ปุ่ม Save ด้านล่างสุด -->
              <div class="text-end">
				<button type="submit" class="btn btn-primary px-4 py-2">
                  <i class="bi bi-plus-circle me-1"></i> Create new
                </button>
                <button type="submit" class="btn btn-primary px-4 py-2">
                  <i class="bi bi-save me-1"></i> Update your list
                </button>
              </div>
            </div>

            <!-- Tab 3: Assign Competency to Staff -->
            <div class="tab-pane fade" id="assign-tab-pane" role="tabpanel" aria-labelledby="assign-tab" tabindex="0">
              
              <!-- ส่วนเลือกพนักงานและอัปโหลดไฟล์ -->
              <div class="card shadow-sm mb-4">
                <div class="card-body">
                  <h5 class="card-title fw-bold mb-3"><i class="bi bi-person-badge me-2"></i>ข้อมูลพนักงานและเอกสารประกอบ</h5>
                  <div class="row g-3 align-items-center">
                    <!-- เลือกรหัสพนักงาน -->
                    <div class="col-md-4">
                      <label for="select_emp_id" class="form-label fw-bold">รหัสพนักงาน</label>
                      <select class="form-select" id="select_emp_id" name="assign_emp_id">
                        <option value="">-- กรุณาเลือกรหัสพนักงาน --</option>
                        <?php foreach ($employees as$emp): ?>
                          <option value="<?php echo $emp['id']; ?>" 
                            data-name="<?php echo $emp['name']; ?>" 
                            data-surname="<?php echo $emp['surname']; ?>" 
                            data-dept="<?php echo $emp['department']; ?>" 
                            data-pos="<?php echo $emp['position']; ?>">
                            <?php echo $emp['id']; ?> - <?php echo $emp['name'] . ' ' .$emp['surname']; ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <!-- แสดงข้อมูลพนักงาน (ชื่อ, นามสกุล, แผนก, ตำแหน่ง) -->
                    <div class="col-md-5">
                      <label class="form-label fw-bold">ข้อมูลพนักงาน</label>
                      <div class="form-control bg-light text-dark" id="emp_info_display" style="min-height: 38px;">
                        <span class="text-muted">โปรดเลือกรหัสพนักงานเพื่อแสดงข้อมูล...</span>
                      </div>
                    </div>

                    <!-- อัปโหลดไฟล์ -->
                    <div class="col-md-3">
                      <label for="upload_file" class="form-label fw-bold">Upload File</label>
                      <input class="form-control" type="file" id="upload_file" name="assign_file">
                    </div>
                  </div>
                </div>
              </div>

              <!-- ส่วนค้นหา Competency -->
              <div class="row mb-3 justify-content-center">
                <div class="col-md-6 text-center">
                  <label for="comp_search_input" class="form-label fw-bold">ค้นหาชื่อ Competency</label>
                  <select class="form-select" id="comp_search_input">
                    <option value="">-- พิมพ์หรือเลือกชื่อ Competency --</option>
                    <?php foreach ($competencies as$comp): ?>
                      <option value="<?php echo $comp['code']; ?>"><?php echo $comp['name_th'] . ' (' .$comp['name_eng'] . ')'; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <!-- ตาราง Competency สำหรับพนักงาน (มี Requirement และ Gain เป็น Text Box ทุก Level) -->
              <div class="card shadow-sm mb-3">
                <div class="card-header bg-light fw-bold">
                  <i class="bi bi-table me-2"></i>รายการ Competency ที่กำหนดให้พนักงาน
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0 staff-competency-table" style="font-size: 0.85rem;">
                      <thead class="table-light text-center">
                        <tr>
                          <th style="width: 5%;">ID</th>
                          <th style="width: 15%;">Competency Name</th>
                          <?php for ($lvl = 1; $lvl <= 5; $lvl++): ?>
                            <th style="width: 16%;">
                              Level <?php echo $lvl; ?>
                              <div class="d-flex justify-content-between text-muted fw-normal mt-1" style="font-size: 0.75rem;">
                                <span>Req</span><span>Gain</span>
                              </div>
                            </th>
                          <?php endfor; ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($competencies as$comp): ?>
                          <tr>
                            <td class="text-center fw-semibold"><?php echo $comp['code']; ?></td>
                            <td class="fw-bold">
                              <?php echo $comp['name_th']; ?>
                              <div class="text-muted small"><?php echo $comp['name_eng']; ?></div>
                            </td>
                            <?php for ($lvl = 1; $lvl <= 5; $lvl++): ?>
                              <td>
                                <div class="mb-1">
                                  <span class="level-definition" style="font-size: 0.8rem;"><?php echo htmlspecialchars($comp['levels'][$lvl], ENT_QUOTES, 'UTF-8'); ?></span>
                                </div>
                                <div class="input-group input-group-sm">
                                  <input type="text" class="form-control" name="req[<?php echo $comp['code']; ?>][<?php echo$lvl; ?>]" placeholder="Req">
                                  <input type="text" class="form-control" name="gain[<?php echo $comp['code']; ?>][<?php echo$lvl; ?>]" placeholder="Gain">
                                </div>
                              </td>
                            <?php endfor; ?>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <!-- ปุ่ม Save ด้านล่างสุดของ Tab 3 -->
              <div class="text-end">
                <button type="submit" class="btn btn-success px-4 py-2">
                  <i class="bi bi-save me-1"></i> Save Staff Competency
                </button>
              </div>

            </div>

          </div><!-- End Tab Content -->

        </form>

      </div>
     
    </section><!-- /About Section -->

  </main>

  <!-- Modal สำหรับแก้ไขข้อมูล Competency -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form id="editForm" method="POST">
          <div class="modal-header">
            <h5 class="modal-title fw-bold" id="editModalLabel"><i class="bi bi-pencil-square me-2"></i>แก้ไขข้อมูล Competency</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <!-- Competency (TH) - แสดงแบบ Text แนวนอน -->
            <div class="row mb-3 align-items-center">
              <label class="col-sm-3 col-form-label fw-bold">Competency (TH):</label>
              <div class="col-sm-9">
                <span id="modal_name_th" class="form-control-plaintext"></span>
              </div>
            </div>

            <!-- Competency (ENG) - แสดงแบบ Text แนวนอน -->
            <div class="row mb-3 align-items-center">
              <label class="col-sm-3 col-form-label fw-bold">Competency (ENG):</label>
              <div class="col-sm-9">
                <span id="modal_name_eng" class="form-control-plaintext"></span>
              </div>
            </div>

            <!-- Description - แสดงแบบ Text แนวนอน -->
            <div class="row mb-3 align-items-start">
              <label class="col-sm-3 col-form-label fw-bold">Description:</label>
              <div class="col-sm-9">
                <span id="modal_description" class="form-control-plaintext"></span>
              </div>
            </div>

            <!-- Category (Dropdown List) -->
            <div class="row mb-3 align-items-center">
              <label for="modal_category" class="col-sm-3 col-form-label fw-bold">Category:</label>
              <div class="col-sm-9">
                <select class="form-select" id="modal_category">
                  <option value="Core">Core</option>
                  <option value="Functional">Functional</option>
                  <option value="Managerial">Managerial</option>
                </select>
              </div>
            </div>

            <!-- Type (Dropdown List) -->
            <div class="row mb-3 align-items-center">
              <label for="modal_type" class="col-sm-3 col-form-label fw-bold">Type:</label>
              <div class="col-sm-9">
                <select class="form-select" id="modal_type">
                  <option value="Skill">Skill</option>
                  <option value="Attitude">Attitude</option>
                  <option value="Knowledge">Knowledge</option>
                </select>
              </div>
            </div>

            <hr>
            <h6 class="fw-bold mb-3">ระดับความสามารถ (Levels)</h6>

            <!-- Level 1 -->
            <div class="row mb-2 align-items-center">
              <label for="modal_lvl1" class="col-sm-3 col-form-label small text-muted">Level 1</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="modal_lvl1">
              </div>
            </div>

            <!-- Level 2 -->
            <div class="row mb-2 align-items-center">
              <label for="modal_lvl2" class="col-sm-3 col-form-label small text-muted">Level 2</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="modal_lvl2">
              </div>
            </div>

            <!-- Level 3 -->
            <div class="row mb-2 align-items-center">
              <label for="modal_lvl3" class="col-sm-3 col-form-label small text-muted">Level 3</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="modal_lvl3">
              </div>
            </div>

            <!-- Level 4 -->
            <div class="row mb-2 align-items-center">
              <label for="modal_lvl4" class="col-sm-3 col-form-label small text-muted">Level 4</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="modal_lvl4">
              </div>
            </div>

            <!-- Level 5 -->
            <div class="row mb-3 align-items-center">
              <label for="modal_lvl5" class="col-sm-3 col-form-label small text-muted">Level 5</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="modal_lvl5">
              </div>
            </div>

            <!-- หมายเหตุ (Text Box แนวนอน) -->
            <div class="row mb-3 align-items-center">
              <label for="modal_remark" class="col-sm-3 col-form-label fw-bold">หมายเหตุ</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="modal_remark">
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> บันทึก</button>
          </div>
        </form>
      </div>
    </div>
  </div>

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

  <!-- Script สำหรับจัดการดึง ID พนักงานจากช่อง Search และ Tab ที่ 3 -->
  <script>
    document.getElementById('employee_search').addEventListener('input', function(e) {
      const inputVal = e.target.value;
      const datalistOptions = document.getElementById('competencyOptions').options;
      let matchedId = '';
      
      for (let option of datalistOptions) {
        if (option.value === inputVal) {
          matchedId = option.getAttribute('data-id');
          break;
        }
      }
      document.getElementById('employee_id').value = matchedId;
    });

    // Script แสดงข้อมูลพนักงานใน Tab ที่ 3 เมื่อเลือก Dropdown รหัสพนักงาน
    document.getElementById('select_emp_id').addEventListener('change', function(e) {
      const selectedOption = e.target.selectedOptions[0];
      const displayDiv = document.getElementById('emp_info_display');
      
      if (e.target.value) {
        const name = selectedOption.getAttribute('data-name');
        const surname = selectedOption.getAttribute('data-surname');
        const dept = selectedOption.getAttribute('data-dept');
        const pos = selectedOption.getAttribute('data-pos');
        
        displayDiv.innerHTML = `<strong>ชื่อ-นามสกุล:</strong> ${name} ${surname} | <strong>แผนก:</strong> ${dept} | <strong>ตำแหน่ง:</strong> ${pos}`;
      } else {
        displayDiv.innerHTML = '<span class="text-muted">โปรดเลือกรหัสพนักงานเพื่อแสดงข้อมูล...</span>';
      }
    });

    // Script ส่งข้อมูลเข้า Modal เมื่อกดปุ่มแก้ไขในแต่ละแถว
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      
      document.getElementById('modal_name_th').textContent = button.getAttribute('data-th');
      document.getElementById('modal_name_eng').textContent = button.getAttribute('data-eng');
      document.getElementById('modal_description').textContent = button.getAttribute('data-desc');
      document.getElementById('modal_category').value = button.getAttribute('data-category');
      document.getElementById('modal_type').value = button.getAttribute('data-type');
      document.getElementById('modal_lvl1').value = button.getAttribute('data-lvl1');
      document.getElementById('modal_lvl2').value = button.getAttribute('data-lvl2');
      document.getElementById('modal_lvl3').value = button.getAttribute('data-lvl3');
      document.getElementById('modal_lvl4').value = button.getAttribute('data-lvl4');
      document.getElementById('modal_lvl5').value = button.getAttribute('data-lvl5');
      document.getElementById('modal_remark').value = button.getAttribute('data-remark');
    });
  </script>

</body>

</html>
<?php
// ==========================================
// 1. ตั้งค่าข้อมูลพนักงานและ Competency Gap
// ==========================================
$employeeName = "คุณสมชาย ใจดี";
$position = "Project Manager";
$competencyGaps = "1. Strategic Thinking (คะแนนปัจจุบัน 2 / ต้องการระดับ 4)\n2. Data-Driven Decision Making (คะแนนปัจจุบัน 2 / ต้องการระดับ 3)";

// ==========================================
// 2. ตั้งค่า API Key (คีย์ประเภทใหม่ของคุณ)
// ==========================================
$apiKey = "AQ.Ab8RN6LlZTDPpcjv1RYL5yqmLq3gJZW2slJL9Y_57x1Pmx9mDg";

// เลือกโมเดลรุ่นปัจจุบัน (เช่น gemini-2.5-flash)
$model = "gemini-3.8-flash"; 
$url = "https://generativelanguage.googleapis.com/v1beta/models/" . $model . ":generateContent?key=" . $apiKey;

// ==========================================
// 3. เตรียม Prompt สำหรับสั่ง AI
// ==========================================
$prompt = "คุณคือที่ปรึกษา HRD ผู้เชี่ยวชาญด้านการพัฒนาบุคลากร 
โปรดสร้างแผนพัฒนาตนเองรายบุคคล (IDP) เป็นภาษาไทย สำหรับพนักงานดังนี้:
- ชื่อ: $employeeName
- ตำแหน่ง: $position
- Competency Gap ที่พบ:
$competencyGaps

กรุณาสร้างแผน IDP โดยใช้โมเดลการพัฒนา 70:20:10 (70% On-the-job, 20% Coaching/Social, 10% Training) และจัดรูปแบบการแสดงผลเป็นตารางหรือหัวข้อย่อยที่อ่านง่าย ชัดเจน และนำไปปฏิบัติได้จริง";

// ==========================================
// 4. จัดเตรียม Payload และส่ง Request ด้วย cURL
// ==========================================
$data = array(
    "contents" => array(
        array(
            "parts" => array(
                array("text" => $prompt)
            )
        )
    )
);

$payload = json_encode($data);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json'
));

// ป้องกันปัญหา SSL Certificate Error บน Localhost (XAMPP / MAMP)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);

// ตรวจสอบข้อผิดพลาดระดับ cURL
if (curl_errno($ch)) {
    $aiResponse = "cURL Error: " . curl_error($ch);
} else {
    curl_close($ch);
    
    // แกะข้อมูล JSON
    $result = json_decode($response, true);
    
    // หากต้องการเปิดดู Error ดิบจาก Google API ให้เอาคอมเมนต์ออก (/* ... */)
    /*
    echo "<pre>"; print_r($result); echo "</pre>"; exit;
    */

    if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
        $aiResponse = $result['candidates'][0]['content']['parts'][0]['text'];
    } else {
        // หากโครงสร้างผิดพลาด จะดึงข้อความแจ้งเตือนจากระบบมาแสดง
        $aiResponse = "เกิดข้อผิดพลาดในการประมวลผลจาก AI: " . (isset($result['error']['message']) ? $result['error']['message'] : json_encode($result));
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ระบบสร้างแผน IDP อัตโนมัติด้วย AI</title>
    <style>
        body { font-family: 'Sarabun', sans-serif; margin: 40px; background: #f4f6f9; color: #333; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); max-width: 800px; margin: auto; }
        h2 { color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .meta-info { background: #eef2f7; padding: 12px 15px; border-radius: 6px; margin-bottom: 20px; }
        .idp-box { background: #f9fafb; border-left: 4px solid #3498db; padding: 20px; white-space: pre-wrap; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="container">
        <h2>รายงานแผนพัฒนาตนเอง (IDP)</h2>
        <div class="meta-info">
            <p style="margin: 5px 0;"><strong>ชื่อพนักงาน:</strong> <?php echo htmlspecialchars($employeeName); ?></p>
            <p style="margin: 5px 0;"><strong>ตำแหน่ง:</strong> <?php echo htmlspecialchars($position); ?></p>
        </div>
        
        <h3>แผน IDP แนะนำจาก AI:</h3>
        <div class="idp-box">
<?php 
    // แสดงผลลัพธ์ IDP
    echo htmlspecialchars($aiResponse); 
?>
        </div>
    </div>
</body>
</html>
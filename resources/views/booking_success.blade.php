<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จองคิวสำเร็จ - ระบบจองคิวซ่อมและล้างแอร์บ้าน</title>
    <!-- Tailwind CSS CDN สไตล์นักศึกษา IT -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Prompt', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800">

    <!-- แถบด้านบน (Navbar) -->
    <header class="bg-blue-600 text-white shadow-sm">
        <div class="max-w-4xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <span class="text-2xl">❄️</span>
                <h1 class="text-xl font-bold">ระบบจองคิวซ่อมและล้างแอร์บ้าน</h1>
            </div>
            <a href="/booking" class="text-sm bg-blue-700 hover:bg-blue-800 px-3.5 py-1.5 rounded-lg transition">
                ➕ จองคิวใหม่
            </a>
        </div>
    </header>

    <!-- การ์ดแจ้งผลสำเร็จ -->
    <main class="max-w-xl mx-auto px-4 py-10">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8 text-center">
            
            <!-- ไอคอนความสำเร็จ -->
            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                ✓
            </div>

            <h2 class="text-2xl font-bold text-slate-800">จองคิวบริการสำเร็จ!</h2>
            <p class="text-sm text-slate-500 mt-1">ระบบได้บันทึกข้อมูลการนัดหมายช่างแอร์ของคุณเรียบร้อยแล้ว</p>

            <!-- กล่องเน้นข้อมูลเบอร์โทรสำหรับติดตามคิว -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4 text-left">
                <div class="flex items-center justify-between border-b border-blue-100 pb-2 mb-2">
                    <span class="text-xs text-blue-700 font-medium">รหัสคิวอ้างอิง:</span>
                    <span class="text-sm font-bold text-blue-900">#BK-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-blue-700 font-medium">เบอร์โทรศัพท์ที่ใช้ติดตามคิว:</span>
                    <span class="text-base font-bold text-blue-900">{{ $booking->phone }}</span>
                </div>
                <p class="text-xs text-blue-600 mt-2 text-center">
                    📌 กรุณาจำเบอร์โทรนี้ไว้เพื่อใช้ตรวจสอบความคืบหน้าของคิวงาน
                </p>
            </div>

            <!-- สรุปรายละเอียดการจอง -->
            <div class="mt-6 border-t border-slate-100 pt-5 text-left text-sm space-y-2.5">
                <div class="flex justify-between">
                    <span class="text-slate-500">ชื่อลูกค้า:</span>
                    <span class="font-medium text-slate-800">{{ $booking->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">บริการ:</span>
                    <span class="font-medium text-slate-800">{{ $booking->service_type }} ({{ $booking->air_count }} เครื่อง)</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">วันที่นัดหมาย:</span>
                    <span class="font-medium text-slate-800">{{ $booking->booking_date }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">ช่วงเวลา:</span>
                    <span class="font-medium text-slate-800">
                        {{ $booking->time_slot === 'morning' ? 'ช่วงเช้า (09:00 - 12:00 น.)' : 'ช่วงบ่าย (13:00 - 17:00 น.)' }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-500">สถานะปัจจุบัน:</span>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                        ⏳ รอยืนยัน (pending)
                    </span>
                </div>
            </div>

            <!-- ปุ่มนำทาง -->
            <div class="mt-8 space-y-3">
                <a href="/track?phone={{ $booking->phone }}"
                    class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-lg shadow-sm transition">
                    🔍 ไปที่หน้าตรวจสอบสถานะคิวงาน
                </a>
                <a href="/booking"
                    class="block w-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium py-2.5 rounded-lg transition text-sm">
                    กลับไปหน้าแบบฟอร์มจองคิว
                </a>
            </div>

        </div>
    </main>

</body>
</html>

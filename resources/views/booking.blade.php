<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จองคิวซ่อมและล้างแอร์บ้าน</title>
    <!-- Tailwind CSS CDN สไตล์นักศึกษา IT ใช้งานง่าย ไม่ต้องติดตั้งเพิ่ม -->
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
            <a href="/track" class="text-sm bg-blue-700 hover:bg-blue-800 px-3.5 py-1.5 rounded-lg transition">
                🔍 ติดตามสถานะคิว
            </a>
        </div>
    </header>

    <!-- เนื้อหาฟอร์มจองคิว -->
    <main class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">
            
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold text-slate-800">แบบฟอร์มจองคิวนัดช่าง</h2>
                <p class="text-sm text-slate-500 mt-1">กรอกข้อมูลการจองคิว เพื่อให้ช่างเข้าไปบริการได้อย่างรวดเร็ว</p>
            </div>

            <!-- ฟอร์มส่งข้อมูลไปยัง POST /booking -->
            <!-- สำคัญ: ต้องใส่ @csrf ป้องกันความปลอดภัย และ enctype สำหรับอัปโหลดรูป -->
            <form action="/booking" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- ข้อมูลติดต่อลูกค้า -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-1">
                            ชื่อ-นามสกุล <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" required
                            placeholder="เช่น นายสมชาย สายลม"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm transition">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-700 mb-1">
                            เบอร์โทรศัพท์ (ใช้ติดตามคิว) <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="phone" name="phone" required
                            placeholder="เช่น 0812345678"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm transition">
                    </div>
                </div>

                <!-- ที่อยู่ -->
                <div>
                    <label for="address" class="block text-sm font-medium text-slate-700 mb-1">
                        ที่อยู่ / บ้านเลขที่ / จุดสังเกต <span class="text-red-500">*</span>
                    </label>
                    <textarea id="address" name="address" rows="2" required
                        placeholder="เช่น 123/45 หมู่บ้านสุขใจ ซอย 5"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm transition"></textarea>
                </div>

                <!-- ประเภทบริการ และ จำนวนแอร์ -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="service_type" class="block text-sm font-medium text-slate-700 mb-1">
                            ประเภทบริการ <span class="text-red-500">*</span>
                        </label>
                        <select id="service_type" name="service_type" required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm transition bg-white">
                            <option value="">-- กรุณาเลือกบริการ --</option>
                            <option value="ล้างแอร์">ล้างแอร์ (ทำความสะอาดทั่วไป)</option>
                            <option value="แอร์น้ำหยด">แอร์น้ำหยด / ท่อน้ำทิ้งตัน</option>
                            <option value="แอร์ไม่เย็น">แอร์ไม่เย็น / เติมน้ำยาแอร์</option>
                            <option value="กลิ่นไหม้ / เสียงดัง">มีกลิ่นไหม้ / เสียงดังผิดปกติ</option>
                            <option value="ซ่อมบำรุงอื่นๆ">ซ่อมบำรุงอื่นๆ</option>
                        </select>
                    </div>

                    <div>
                        <label for="air_count" class="block text-sm font-medium text-slate-700 mb-1">
                            จำนวนเครื่องแอร์ (เครื่อง) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="air_count" name="air_count" min="1" value="1" required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm transition">
                    </div>
                </div>

                <!-- วันที่นัดหมาย และ ช่วงเวลา -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="booking_date" class="block text-sm font-medium text-slate-700 mb-1">
                            วันที่ต้องการนัดหมาย <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="booking_date" name="booking_date" required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm transition">
                    </div>

                    <div>
                        <label for="time_slot" class="block text-sm font-medium text-slate-700 mb-1">
                            ช่วงเวลานัดหมาย <span class="text-red-500">*</span>
                        </label>
                        <select id="time_slot" name="time_slot" required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm transition bg-white">
                            <option value="morning">ช่วงเช้า (09:00 - 12:00 น.)</option>
                            <option value="afternoon">ช่วงบ่าย (13:00 - 17:00 น.)</option>
                        </select>
                    </div>
                </div>

                <!-- รายละเอียดอาการเพิ่มเติม -->
                <div>
                    <label for="details" class="block text-sm font-medium text-slate-700 mb-1">
                        อาการเพิ่มเติม / รายละเอียดอื่นๆ (ไม่บังคับ)
                    </label>
                    <textarea id="details" name="details" rows="2"
                        placeholder="เช่น แอร์ห้องนอนชั้น 2 เสียงพัดลมดังตอนเปิดเบอร์แรง"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm transition"></textarea>
                </div>

                <!-- อัปโหลดรูปภาพ -->
                <div>
                    <label for="image" class="block text-sm font-medium text-slate-700 mb-1">
                        รูปภาพอาการแอร์หรือหน้างาน (ไม่บังคับ)
                    </label>
                    <input type="file" id="image" name="image" accept="image/*"
                        class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                </div>

                <!-- ปุ่มกดยืนยัน -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-lg shadow-sm transition flex justify-center items-center space-x-2">
                        <span>🗓️ ยืนยันการจองคิวงาน</span>
                    </button>
                </div>
            </form>

        </div>
    </main>

</body>
</html>

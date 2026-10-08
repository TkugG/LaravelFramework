<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ติดตามสถานะคิวงาน - ระบบจองคิวซ่อมและล้างแอร์บ้าน</title>
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
                <a href="/booking" class="text-xl font-bold hover:text-blue-100 transition">ระบบจองคิวซ่อมและล้างแอร์บ้าน</a>
            </div>
            <a href="/booking" class="text-sm bg-blue-700 hover:bg-blue-800 px-3.5 py-1.5 rounded-lg transition">
                ➕ จองคิวนัดช่าง
            </a>
        </div>
    </header>

    <!-- เนื้อหาหลัก -->
    <main class="max-w-2xl mx-auto px-4 py-8">
        
        <!-- กล่องค้นหาด้วยเบอร์โทรศัพท์ -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-6">
            <h2 class="text-xl font-bold text-slate-800 mb-2">🔍 ตรวจสอบและติดตามสถานะคิวงาน</h2>
            <p class="text-sm text-slate-500 mb-4">กรอกเบอร์โทรศัพท์ที่คุณใช้ตอนจอง เพื่อดูสถานะการนัดหมายช่างแอร์</p>

            <form action="/track" method="GET" class="flex gap-2">
                <input type="tel" name="phone" value="{{ $phone ?? '' }}" required
                    placeholder="กรอกเบอร์โทรศัพท์ เช่น 0812345678"
                    class="flex-1 px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none text-sm transition">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium text-sm transition flex items-center gap-1">
                    <span>ค้นหา</span>
                </button>
            </form>
        </div>

        <!-- ส่วนแสดงผลลัพธ์การค้นหา -->
        @if ($bookings !== null)
            @if ($bookings->isEmpty())
                <!-- กรณีค้นหาแล้วไม่พบข้อมูล -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 text-center">
                    <div class="text-4xl mb-3">📭</div>
                    <h3 class="text-lg font-bold text-slate-700">ไม่พบข้อมูลการจองคิว</h3>
                    <p class="text-sm text-slate-500 mt-1">ไม่พบคิวงานที่ตรงกับเบอร์โทร <span class="font-semibold text-slate-700">{{ $phone }}</span></p>
                    <a href="/booking" class="inline-block mt-4 text-sm text-blue-600 hover:underline">
                        ➕ คลิกที่นี่เพื่อไปจองคิวนัดช่างใหม่
                    </a>
                </div>
            @else
                <!-- กรณีพบคิวงาน -->
                <div class="space-y-4">
                    <div class="flex justify-between items-center px-1">
                        <span class="text-sm font-semibold text-slate-600">ผลการค้นหาพบ {{ $bookings->count() }} รายการ</span>
                        <span class="text-xs text-slate-400">เบอร์โทร: {{ $phone }}</span>
                    </div>

                    @foreach ($bookings as $item)
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 md:p-6 transition hover:shadow-md">
                            
                            <!-- หัวการ์ด: รหัสคิว + ป้ายสถานะสีตามที่ตกลงกัน -->
                            <div class="flex justify-between items-start border-b border-slate-100 pb-3 mb-3">
                                <div>
                                    <span class="text-xs text-slate-400">รหัสคิว:</span>
                                    <span class="text-base font-bold text-slate-800">#BK-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    <p class="text-xs text-slate-500 mt-0.5">จองเมื่อ: {{ $item->created_at->format('d/m/Y H:i') }}</p>
                                </div>

                                <!-- ป้ายสีสถานะ (Status Badge) ตามตาราง Checklist -->
                                <div>
                                    @if ($item->status === 'pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                            ⏳ รอยืนยัน
                                        </span>
                                    @elseif ($item->status === 'confirmed')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                            📅 นัดหมายแล้ว
                                        </span>
                                    @elseif ($item->status === 'fixing')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                            🔧 กำลังซ่อม
                                        </span>
                                    @elseif ($item->status === 'completed')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            ✅ เสร็จสิ้น
                                        </span>
                                    @elseif ($item->status === 'cancelled')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            ❌ ยกเลิก
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-800">
                                            {{ $item->status }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- รายละเอียดคิวงาน -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                <div>
                                    <span class="text-slate-400 text-xs block">ประเภทบริการ:</span>
                                    <span class="font-medium text-slate-800">{{ $item->service_type }} ({{ $item->air_count }} เครื่อง)</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 text-xs block">วันเวลานัดหมายช่าง:</span>
                                    <span class="font-medium text-slate-800">
                                        {{ $item->booking_date }} 
                                        ({{ $item->time_slot === 'morning' ? 'ช่วงเช้า 09:00 - 12:00' : 'ช่วงบ่าย 13:00 - 17:00' }})
                                    </span>
                                </div>
                                <div class="md:col-span-2">
                                    <span class="text-slate-400 text-xs block">ที่อยู่นัดหมาย:</span>
                                    <span class="text-slate-700">{{ $item->address }}</span>
                                </div>
                                @if ($item->details)
                                    <div class="md:col-span-2 bg-slate-50 p-2.5 rounded-lg text-xs text-slate-600">
                                        <span class="font-medium">อาการเพิ่มเติม:</span> {{ $item->details }}
                                    </div>
                                @endif
                                @if ($item->image)
                                    <div class="md:col-span-2 pt-1">
                                        <span class="text-slate-400 text-xs block mb-1">รูปภาพแนบ:</span>
                                        <a href="{{ asset('storage/' . $item->image) }}" target="_blank"
                                            class="inline-block text-xs text-blue-600 hover:underline">
                                            📷 คลิกดูรูปภาพแนบ
                                        </a>
                                    </div>
                                @endif
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif
        @endif

    </main>

</body>
</html>

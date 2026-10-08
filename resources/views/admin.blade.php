<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - จัดการคิวงานช่างแอร์</title>
    <!-- Tailwind CSS CDN สไตล์นักศึกษา IT -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Prompt', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen text-slate-800">

    <!-- แถบด้านบน (Navbar Admin) -->
    <header class="bg-slate-800 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex flex-wrap justify-between items-center gap-3">
            <div class="flex items-center space-x-3">
                <span class="text-2xl">🛠️</span>
                <div>
                    <h1 class="text-lg font-bold">ระบบจัดการคิวงานช่างแอร์ (Admin Dashboard)</h1>
                    <p class="text-xs text-slate-400">สำหรับช่างและเจ้าของร้านตรวจสอบและอัปเดตสถานะงาน</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="/booking" target="_blank" class="text-xs bg-slate-700 hover:bg-slate-600 px-3 py-1.5 rounded-lg transition">
                    🌐 เปิดหน้าจองคิวลูกค้า
                </a>
                <a href="/track" target="_blank" class="text-xs bg-slate-700 hover:bg-slate-600 px-3 py-1.5 rounded-lg transition">
                    🔍 หน้าติดตามสถานะ
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-6">

        <!-- ข้อความแจ้งเตือนเมื่ออัปเดตสำเร็จ -->
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm flex items-center justify-between">
                <span>✅ {{ session('success') }}</span>
            </div>
        @endif

        <!-- ส่วนที่ 1: การ์ดตัวเลขสรุปยอดคิวงาน (Checklist 4.3) -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">คิวงานทั้งหมด</span>
                <span class="text-3xl font-extrabold text-slate-800 mt-2 block">{{ $totalBookings }}</span>
                <span class="text-xs text-slate-400 mt-1 block">รายการ</span>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-amber-500">
                <span class="text-xs font-semibold text-amber-600 uppercase tracking-wider block">รอยืนยัน (Pending)</span>
                <span class="text-3xl font-extrabold text-amber-600 mt-2 block">{{ $pendingCount }}</span>
                <span class="text-xs text-slate-400 mt-1 block">ลูกค้ารอนัด</span>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-blue-500">
                <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider block">กำลังดำเนินการ</span>
                <span class="text-3xl font-extrabold text-blue-600 mt-2 block">{{ $inProgressCount }}</span>
                <span class="text-xs text-slate-400 mt-1 block">นัดแล้ว / กำลังซ่อม</span>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-green-500">
                <span class="text-xs font-semibold text-green-600 uppercase tracking-wider block">เสร็จสิ้น (Completed)</span>
                <span class="text-3xl font-extrabold text-green-600 mt-2 block">{{ $completedCount }}</span>
                <span class="text-xs text-slate-400 mt-1 block">ปิดงานรับเงินแล้ว</span>
            </div>
        </div>

        <!-- ส่วนที่ 2: ตารางแสดงรายการคิวงานทั้งหมด (Checklist 4.1 & 4.2) -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <h2 class="font-bold text-slate-800 text-base">📋 รายการคิวงานทั้งหมด เรียงตามวันนัดหมาย</h2>
                <span class="text-xs text-slate-400">อัปเดตล่าสุด: {{ now()->format('d/m/Y H:i') }}</span>
            </div>

            @if ($bookings->isEmpty())
                <div class="p-12 text-center text-slate-400">
                    <p class="text-4xl mb-2">📭</p>
                    <p class="text-sm">ยังไม่มีรายการจองคิวงานในระบบ</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-600 text-xs uppercase border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3 font-semibold">รหัสคิว</th>
                                <th class="px-4 py-3 font-semibold">วัน-เวลานัด</th>
                                <th class="px-4 py-3 font-semibold">ข้อมูลลูกค้า</th>
                                <th class="px-4 py-3 font-semibold">บริการ / แอร์</th>
                                <th class="px-4 py-3 font-semibold">รายละเอียด / ที่อยู่</th>
                                <th class="px-4 py-3 font-semibold">สถานะปัจจุบัน</th>
                                <th class="px-4 py-3 font-semibold text-center">เปลี่ยนสถานะ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($bookings as $item)
                                <tr class="hover:bg-slate-50 transition">
                                    
                                    <!-- รหัสคิว -->
                                    <td class="px-4 py-3 font-bold text-slate-800 whitespace-nowrap">
                                        #BK-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                                        @if ($item->image)
                                            <div class="mt-1">
                                                <a href="{{ asset('storage/' . $item->image) }}" target="_blank"
                                                    class="inline-flex items-center text-xs text-blue-600 hover:underline">
                                                    📷 ดูรูปแนบ
                                                </a>
                                            </div>
                                        @endif
                                    </td>

                                    <!-- วันเวลานัด -->
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="font-medium text-slate-800">{{ $item->booking_date }}</div>
                                        <div class="text-xs text-slate-500">
                                            {{ $item->time_slot === 'morning' ? 'ช่วงเช้า (09-12น.)' : 'ช่วงบ่าย (13-17น.)' }}
                                        </div>
                                    </td>

                                    <!-- ข้อมูลลูกค้า -->
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-slate-800">{{ $item->name }}</div>
                                        <div class="text-xs text-slate-500">📞 {{ $item->phone }}</div>
                                    </td>

                                    <!-- บริการ -->
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-slate-800">{{ $item->service_type }}</div>
                                        <div class="text-xs text-slate-500">{{ $item->air_count }} เครื่อง</div>
                                    </td>

                                    <!-- ที่อยู่ และ อาการ -->
                                    <td class="px-4 py-3 max-w-xs">
                                        <div class="text-xs text-slate-700 truncate" title="{{ $item->address }}">📍 {{ $item->address }}</div>
                                        @if ($item->details)
                                            <div class="text-xs text-slate-500 mt-0.5 truncate" title="{{ $item->details }}">💬 {{ $item->details }}</div>
                                        @endif
                                    </td>

                                    <!-- ป้ายสีสถานะปัจจุบัน -->
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if ($item->status === 'pending')
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                                ⏳ รอยืนยัน
                                            </span>
                                        @elseif ($item->status === 'confirmed')
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                                📅 นัดหมายแล้ว
                                            </span>
                                        @elseif ($item->status === 'fixing')
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                                🔧 กำลังซ่อม
                                            </span>
                                        @elseif ($item->status === 'completed')
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                ✅ เสร็จสิ้น
                                            </span>
                                        @elseif ($item->status === 'cancelled')
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                ❌ ยกเลิก
                                            </span>
                                        @endif
                                    </td>

                                    <!-- แบบฟอร์มปุ่มเปลี่ยนสถานะงาน (Checklist 4.2) -->
                                    <td class="px-4 py-3 whitespace-nowrap text-center">
                                        <form action="/admin/bookings/{{ $item->id }}/status" method="POST" class="inline-flex items-center gap-1.5">
                                            @csrf
                                            <select name="status" class="text-xs border border-slate-300 rounded-lg px-2 py-1.5 bg-white outline-none focus:ring-1 focus:ring-blue-500">
                                                <option value="pending" {{ $item->status === 'pending' ? 'selected' : '' }}>รอยืนยัน</option>
                                                <option value="confirmed" {{ $item->status === 'confirmed' ? 'selected' : '' }}>นัดหมายแล้ว</option>
                                                <option value="fixing" {{ $item->status === 'fixing' ? 'selected' : '' }}>กำลังซ่อม</option>
                                                <option value="completed" {{ $item->status === 'completed' ? 'selected' : '' }}>เสร็จสิ้น</option>
                                                <option value="cancelled" {{ $item->status === 'cancelled' ? 'selected' : '' }}>ยกเลิก</option>
                                            </select>
                                            <button type="submit" class="bg-slate-800 hover:bg-slate-700 text-white text-xs px-2.5 py-1.5 rounded-lg transition font-medium">
                                                บันทึก
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </main>

</body>
</html>

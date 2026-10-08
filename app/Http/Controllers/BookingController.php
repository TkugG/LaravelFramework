<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    // หน้าฟอร์มสำหรับจองคิว
    public function create()
    {
        return view('booking');
    }

    // บันทึกข้อมูลการจองคิวลงฐานข้อมูล
    public function store(Request $request)
    {
        // 1. ตรวจสอบความถูกต้องของข้อมูล (Validation)
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'service_type' => 'required',
            'air_count' => 'required|numeric',
            'booking_date' => 'required|date',
            'time_slot' => 'required',
            'image' => 'nullable|image|max:2048', // แนบรูปได้ไม่เกิน 2MB
        ]);

        // 2. จัดการบันทึกไฟล์รูปภาพ (ถ้ามีแนบมา)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('bookings', 'public');
        }

        // 3. บันทึกข้อมูลลงตาราง bookings ผ่าน Model
        $booking = Booking::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'service_type' => $request->service_type,
            'air_count' => $request->air_count,
            'details' => $request->details,
            'booking_date' => $request->booking_date,
            'time_slot' => $request->time_slot,
            'image' => $imagePath,
            'status' => 'pending', // สถานะเริ่มต้นเป็น pending ตามข้อตกลง
        ]);

        // 4. ส่งข้อมูลไปยังหน้าแจ้งผลจองสำเร็จ
        return view('booking_success', ['booking' => $booking]);
    }

    // ค้นหาและติดตามสถานะคิวงานด้วยเบอร์โทรศัพท์
    public function track(Request $request)
    {
        $phone = $request->input('phone');
        $bookings = null;

        // ถ้าผู้ใช้กรอกเบอร์โทรมา ให้ค้นหาในฐานข้อมูล
        if ($phone) {
            $bookings = Booking::where('phone', $phone)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('track', [
            'bookings' => $bookings,
            'phone' => $phone,
        ]);
    }

    // หน้า Dashboard รวมคิวงานทั้งหมดสำหรับช่าง/ร้าน
    public function admin()
    {
        // 1. ดึงรายการจองทั้งหมด เรียงลำดับตามวันที่นัดหมาย
        $bookings = Booking::orderBy('booking_date', 'asc')->get();

        // 2. สรุปตัวเลขสถิติสำหรับการ์ดด้านบน (Dashboard Cards)
        $totalBookings = Booking::count();
        $pendingCount = Booking::where('status', 'pending')->count();
        $inProgressCount = Booking::whereIn('status', ['confirmed', 'fixing'])->count();
        $completedCount = Booking::where('status', 'completed')->count();

        return view('admin', [
            'bookings' => $bookings,
            'totalBookings' => $totalBookings,
            'pendingCount' => $pendingCount,
            'inProgressCount' => $inProgressCount,
            'completedCount' => $completedCount,
        ]);
    }

    // ฟังก์ชันสำหรับช่างกดเปลี่ยนสถานะงาน
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => $request->status,
        ]);

        return redirect('/admin')->with('success', 'อัปเดตสถานะคิวงานเรียบร้อยแล้ว');
    }
}

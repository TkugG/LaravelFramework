<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    // กำหนดฟิลด์ที่อนุญาตให้บันทึกลง Database ได้ (Mass Assignment Protection)
    protected $fillable = [
        'name',
        'phone',
        'address',
        'service_type',
        'air_count',
        'details',
        'booking_date',
        'time_slot',
        'image',
        'status',
    ];
}

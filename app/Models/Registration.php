<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\OrderProduct;

class Registration extends Model
{
    use HasFactory;

    protected $table = 'registration_t';

    protected $fillable = [
        'patient_id',
        'registration_number',
        'patient_weight',
        'patient_blood_pressure',
        'patient_complaint',
        'diagnostic_result'
    ];

    public function patient() {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function orderProducts() {
        return $this->hasMany(OrderProduct::class, 'registration_number', 'registration_number');
    }

    protected static function boot() {
        parent::boot();

        static::creating(function ($registration) {
            $today = now()->toDateString();
            $countToday = static::whereDate('created_at', $today)->count() + 1;

            $prefix = 'REG';
            $datePart = now()->format('dm');
            $yearPart = now()->format('Y');
            $sequence = str_pad($countToday, 4, '0', STR_PAD_LEFT);

            $registration->registration_number = $prefix . $datePart . $yearPart . $sequence;
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Registration;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patient_m';

    protected $fillable = [
        'name',
        'birth_date',
        'gender',
        'phone_number'
    ];

    public function registrations() {
        return $this->hasMany(Registration::class, 'patient_id');
    }
}

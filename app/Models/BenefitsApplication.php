<?php

namespace App\Models;

use App\Models\Benefit;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BenefitsApplication extends Model
{
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function benefits()
    {
    return $this->hasMany(Benefit::class, 'employee_id');
    }
}

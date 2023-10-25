<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\BenefitsApplication;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Benefit extends Model
{
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function benefitsApplication()
    {
        return $this->hasMany(BenefitsApplication::class, 'employee_id');
    }
}

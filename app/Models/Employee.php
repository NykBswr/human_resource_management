<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use App\Models\Benefit;
use App\Models\Payroll;
use App\Models\Attendance;
use App\Models\Performance;
use App\Models\BenefitsApplication;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['firstname', 'lastname', 'position', 'salary'];
    
    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class, 'employee_id');
    }
    public function performances()
    {
        return $this->hasMany(Performance::class, 'employee_id');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'employee_id');
    }
    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'employee_id');
    }

    public function benefits()
    {
        return $this->hasMany(Benefit::class, 'employee_id');
    }

    public function offDays()
    {
        return $this->hasMany(OffDays::class, 'employee_id');
    }
    public function benefitsApplication()
    {
        return $this->hasMany(BenefitsApplication::class, 'employee_id');
    }
}

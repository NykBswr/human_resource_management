<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payroll extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['salary_amount', 'request_amount', 'status', 'tax_deduction', 'payment_date'];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}

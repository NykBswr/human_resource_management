<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offdays extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['employee_id', 'info', 'status', 'reason', 'start', 'end'];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}

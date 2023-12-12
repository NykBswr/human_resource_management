<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';
    protected $primaryKey = 'id';
    protected $fillable = ['employee_id', 'date', 'status', 'in', 'out'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}

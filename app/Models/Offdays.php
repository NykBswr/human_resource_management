<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offdays extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = ['employee_id', 'info', 'status', 'reason', 'start', 'end'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'employee_id', 'employee_id');
    }

    public function updateAttendanceStatus()
    {
        if ($this->status == 2) {
            $this->attendances()->whereBetween('date', [$this->start, $this->end])->update(['status' => 2]);
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($offday) {
            $offday->updateAttendanceStatus();
        });

        static::deleted(function ($offday) {
            $offday->updateAttendanceStatus();
        });
    }
}

<?php

namespace App\Models;

use App\Models\Performance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['taskname', 'taskdescriptions', 'file', 'deadline', 'employee_id', 'progress'];

    public function performances()
    {
        return $this->hasOne(Performance::class, 'task_id');
    }
    public function performance()
    {
        return $this->hasOne(Performance::class);
    }
}

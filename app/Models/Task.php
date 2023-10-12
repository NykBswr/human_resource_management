<?php

namespace App\Models;

use App\Models\Performance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    public function performances()
    {
        return $this->hasMany(Performance::class, 'task_id');
    }
}

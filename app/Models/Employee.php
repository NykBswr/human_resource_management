<?php

namespace App\Models;

use App\Models\User;
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
    // Relasi dengan Performances
    public function performances()
    {
        return $this->hasMany(Performance::class, 'employee_id');
    }
}

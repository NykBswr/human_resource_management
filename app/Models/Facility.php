<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $table = 'facilities';
    protected $primaryKey = 'facility_id';

    protected $fillable = ['remain', 'description'];
    public function employees()
    {
    return $this->belongsToMany(Employee::class, 'employee_facility', 'facility_id', 'employee_id');
    }
}

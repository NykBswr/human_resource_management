<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeFacility extends Model
{
    protected $table = 'employee_facility';
    protected $primaryKey = 'id';

    protected $fillable = ['employee_id', 'facility_id'];
}

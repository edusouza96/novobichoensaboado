<?php

namespace BichoEnsaboado\Models;

use BichoEnsaboado\Models\User;
use BichoEnsaboado\Models\Outlay;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalary extends Model
{

    protected $table = 'employee_salaries';

    public function outlays()
    {
        return $this->belongsTo(Outlay::class, 'outlay_id');
    }
  
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function getId()
    {
        return $this->id;
    }
   
    public function getOutlays()
    {
        return $this->outlays;
    }
  
    public function getUsers()
    {
        return $this->users;
    }
  
    public function isSalaryAdvance()
    {
        return $this->salary_advance;
    }
}

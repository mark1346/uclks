<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
    ];

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'department_module', 'department_id', 'module_id')->withPivot('study_year');
    }
}

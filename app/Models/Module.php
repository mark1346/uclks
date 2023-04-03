<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        "code",
        "name",
    ];

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}

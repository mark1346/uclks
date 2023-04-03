<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        "is_compulsory",
        "module_difficulty",
        "amount_of_assignments",
        "exam_difficulty",
        "tips",
        "evaluation",
        "comments",
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}

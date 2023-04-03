<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $primaryKey = "user_id";

    protected $fillable = [
        "user_id",
        "name",
        "birthday",
        "gender",
        "degree",
        "department",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

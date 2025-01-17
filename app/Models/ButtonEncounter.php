<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ButtonEncounter extends Model
{
    use HasFactory;
    protected $table = "button_encounter";
    protected $fillable = [
        "user_id", "button_pressed", "status"
    ];
}

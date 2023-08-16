<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReligiousOccasion extends Model
{
    use HasFactory;

    protected $table = 'religious_occasions';

    protected $fillable = ['user_id', 'date', 'date_type', 'occasion', 'status'];
}

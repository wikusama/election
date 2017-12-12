<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'id',
        'lead_name',
        'lead_about',
        'lead_pic',
        'deputy_name',
        'deputy_about',
        'deputy_pic',
        'vision',
        'mission'
    ];
}

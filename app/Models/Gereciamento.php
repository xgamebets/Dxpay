<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Gereciamento extends Model
{
    use HasFactory;

    protected $table = 'ip';
    protected $fillable = [
        'status',
        'ip',
        'user_id'
    ];

}
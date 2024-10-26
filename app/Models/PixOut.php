<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PixOut extends Model
{
    use HasFactory;

    protected $table = 'pix_out';
    protected $fillable = [
        'endToEndId',
        'amount',
        'user_id'
    ];

}
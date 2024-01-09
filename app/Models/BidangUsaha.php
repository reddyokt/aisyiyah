<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangUsaha extends Model
{
    use HasFactory;

    protected $table = 'bidangusaha';
    protected $fillable = ['name', 'description', 'isActive'];
}

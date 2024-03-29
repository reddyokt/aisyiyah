<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Majelis extends Model
{
    use HasFactory;

    protected $table = 'majelis';
    protected $fillable = ['name','code', 'type', 'description', 'isActive'];
    protected $primaryKey = 'id_majelis';

}

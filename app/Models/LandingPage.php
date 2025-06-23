<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    use HasFactory;

    protected $table = 'landing_page';
    protected $fillable = ['header1','header2'];
    protected $primaryKey = 'id_landing';
    
}

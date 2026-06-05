<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kader extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kader_info';
    protected $fillable = [ 'kader_name','kader_phone',
                            'kader_email','gender',
                            'marital','address',
                            'anak','pekerjaan_id',
                            'nba','nbm',
                            'ranting_id','status',
                            'deleted_at'
                            ];
    protected $primaryKey = 'kader_id';
}

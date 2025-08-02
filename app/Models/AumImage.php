<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AumImage extends Model
{
    use HasFactory;

    protected $table = 'aum_image';
    protected $fillable = ['id_aum',
                           'images', 
                           'deleted_at', 
                           'created_by'
                            ];
    protected $primaryKey = 'id_aum_image';


}

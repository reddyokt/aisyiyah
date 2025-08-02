<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailsurat extends Model
{
    use HasFactory;

    protected $table = 'surat_detail';
    protected $fillable = ['surat_id','kepada_id','disposisi_to', 'status', 'created_by'];

    protected $primaryKey = 'id_detail';

}

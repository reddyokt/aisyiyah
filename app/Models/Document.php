<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $table = 'document';
    protected $primaryKey = 'id_doc';

    protected $fillable = [
        'docname',
        'id_filetype',
        'pda_id',
        'pca_id',
        'created_by',
        'uploaded_doc',
    ];

    protected $dates = ['deleted_at'];
}

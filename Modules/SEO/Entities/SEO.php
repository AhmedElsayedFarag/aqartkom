<?php

namespace Modules\SEO\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SEO extends Model
{

    use HasFactory;
    protected $table = "s_e_os";
    protected $fillable = [
        'key', 'value', 'type'
    ];
}
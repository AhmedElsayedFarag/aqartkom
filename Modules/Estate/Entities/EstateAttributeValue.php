<?php

namespace Modules\Estate\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstateAttributeValue extends Model
{
    use HasFactory;
    protected $fillable = ['estate_attribute_id', 'value'];
}
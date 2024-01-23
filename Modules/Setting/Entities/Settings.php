<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'key', 'value', 'group',
    ];

    public function scopeGroup(Builder $query, string $group)
    {
        return $query->where('group', $group)->select(['id', 'key', 'value']);
    }
}
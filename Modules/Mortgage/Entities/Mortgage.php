<?php

namespace Modules\Mortgage\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mortgage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'gender',
        'age',
        'bank',
        'group',
        'salary',
        'area',
        'nationality'
    ];

    public function scopeSearch(Builder $builder, ?string $search): Builder
    {
        return $builder->when($search, function (Builder $query) use ($search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }
    public function scopeAge(Builder $builder, ?int $age = null): Builder
    {
        return $builder->when($age, function (Builder $query) use ($age) {
            return $query->where('age', $age);
        });
    }
    public function scopeBank(Builder $builder, ?int $bank = null): Builder
    {
        return $builder->when($bank, function (Builder $query) use ($bank) {
            return $query->where('bank', $bank);
        });
    }
    public function scopeArea(Builder $builder, ?int $area = null): Builder
    {
        return $builder->when($area, function (Builder $query) use ($area) {
            return $query->where('area', $area);
        });
    }
}

<?php

namespace Modules\Favorite\Contracts;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

interface FavoriteInterface
{

    public function  toggle(int $modelID);
    public function getAll();
    public function validate(string $modelUUID): int|ModelNotFoundException;
    public function toJson(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    public function render(): JsonResponse;
    public function isExist(int $id): bool;
}
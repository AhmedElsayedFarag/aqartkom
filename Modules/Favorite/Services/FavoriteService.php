<?php

namespace Modules\Favorite\Services;

use Modules\Favorite\Contracts\FavoriteInterface;

class FavoriteService
{
    public function __construct(private FavoriteInterface $favoriteService)
    {
    }
    public function toggle(string $modelUUID)
    {
        $id = $this->favoriteService->validate($modelUUID);
        return $this->favoriteService->toggle($id);
    }
    public function toJson()
    {
        return $this->favoriteService->toJson();
    }
    public function getAll()
    {
        return $this->favoriteService->getAll();
    }
    public function render()
    {
        return $this->favoriteService->render();
    }
    public function isExist(int $id)
    {
        return $this->favoriteService->isExist($id);
    }
}
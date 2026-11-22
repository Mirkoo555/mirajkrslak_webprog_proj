<?php

require_once __DIR__ . '/BaseDAO.php';

class FavoriteDAO extends BaseDAO
{
    protected string $table = 'favorites';
    protected string $primaryKey = 'favorite_id';

    protected array $allowedFields = [
        'user_id',
        'car_id'
    ];
}

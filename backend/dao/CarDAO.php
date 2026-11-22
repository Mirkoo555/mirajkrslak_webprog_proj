<?php

require_once __DIR__ . '/BaseDAO.php';

class CarDAO extends BaseDAO
{
    protected string $table = 'cars';
    protected string $primaryKey = 'car_id';

    protected array $allowedFields = [
        'user_id',
        'brand_id',
        'model',
        'year',
        'price',
        'fuel_type',
        'transmission',
        'description'
    ];
}

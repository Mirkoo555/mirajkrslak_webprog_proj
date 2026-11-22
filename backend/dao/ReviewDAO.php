<?php

require_once __DIR__ . '/BaseDAO.php';

class ReviewDAO extends BaseDAO
{
    protected string $table = 'reviews';
    protected string $primaryKey = 'review_id';

    protected array $allowedFields = [
        'user_id',
        'car_id',
        'rating',
        'comment'
    ];
}

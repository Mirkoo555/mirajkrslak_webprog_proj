<?php

require_once __DIR__ . '/BaseDAO.php';

class BrandDAO extends BaseDAO
{
    protected string $table = 'brands';
    protected string $primaryKey = 'brand_id';

    protected array $allowedFields = [
        'brand_name',
        'country',
        'logo_url'
    ];
}

<?php

require_once __DIR__ . '/BaseDAO.php';

class UserDAO extends BaseDAO
{
    protected string $table = 'users';
    protected string $primaryKey = 'user_id';

    protected array $allowedFields = [
        'full_name',
        'email',
        'password',
        'role'
    ];
}

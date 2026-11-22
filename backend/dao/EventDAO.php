<?php

require_once __DIR__ . '/BaseDAO.php';

class EventDAO extends BaseDAO
{
    protected string $table = 'events';
    protected string $primaryKey = 'event_id';

    protected array $allowedFields = [
        'user_id',
        'title',
        'description',
        'location',
        'event_date'
    ];
}

<?php

require_once __DIR__ . '/../dao/FavoriteDAO.php';

class FavoriteService
{
    private FavoriteDAO $favoriteDAO;

    public function __construct()
    {
        $this->favoriteDAO = new FavoriteDAO();
    }

    public function getAllFavorites(): array
    {
        return $this->favoriteDAO->getAll();
    }

    public function getFavoriteById(int $id): array
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid favorite ID.');
        }

        $favorite = $this->favoriteDAO->getById($id);

        if (!$favorite) {
            throw new InvalidArgumentException('Favorite not found.');
        }

        return $favorite;
    }

    public function createFavorite(array $data): string
    {
        $this->validateFavoriteData($data);
        $this->checkDuplicate($data);

        return $this->favoriteDAO->create($data);
    }

    public function updateFavorite(int $id, array $data): bool
    {
        $this->getFavoriteById($id);
        $this->validateFavoriteData($data);
        $this->checkDuplicate($data, $id);

        return $this->favoriteDAO->update($id, $data);
    }

    public function deleteFavorite(int $id): bool
    {
        $this->getFavoriteById($id);

        return $this->favoriteDAO->delete($id);
    }

    private function checkDuplicate(array $data, ?int $excludeId = null): void
    {
        foreach ($this->favoriteDAO->getAll() as $favorite) {
            if (
                (int) $favorite['user_id'] === (int) $data['user_id'] &&
                (int) $favorite['car_id'] === (int) $data['car_id'] &&
                (int) $favorite['favorite_id'] !== $excludeId
            ) {
                throw new InvalidArgumentException(
                    'This car is already in the user favorites.'
                );
            }
        }
    }

    private function validateFavoriteData(array $data): void
    {
        if (empty($data)) {
            throw new InvalidArgumentException('Favorite data cannot be empty.');
        }

        foreach (['user_id', 'car_id'] as $field) {
            if (
                !isset($data[$field]) ||
                !is_numeric($data[$field]) ||
                (int) $data[$field] <= 0
            ) {
                throw new InvalidArgumentException("Invalid {$field}.");
            }
        }
    }
}
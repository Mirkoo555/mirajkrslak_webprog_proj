<?php

require_once __DIR__ . '/../dao/CarDAO.php';

class CarService
{
    private CarDAO $carDAO;

    public function __construct()
    {
        $this->carDAO = new CarDAO();
    }

    public function getAllCars(): array
    {
        return $this->carDAO->getAll();
    }

    public function getCarById(int $id): array
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid car ID.');
        }

        $car = $this->carDAO->getById($id);

        if (!$car) {
            throw new InvalidArgumentException('Car not found.');
        }

        return $car;
    }

    public function createCar(array $data): string
    {
        $this->validateCarData($data, true);

        return $this->carDAO->create($data);
    }

    public function updateCar(int $id, array $data): bool
    {
        $this->getCarById($id);

        $this->validateCarData($data, false);

        return $this->carDAO->update($id, $data);
    }

    public function deleteCar(int $id): bool
    {
        $this->getCarById($id);

        return $this->carDAO->delete($id);
    }

    private function validateCarData(array $data, bool $isNew): void
    {
        if ($isNew) {
            $requiredFields = [
                'user_id',
                'brand_id',
                'model',
                'year',
                'price'
            ];

            foreach ($requiredFields as $field) {
                if (!isset($data[$field]) || $data[$field] === '') {
                    throw new InvalidArgumentException(
                        "Field {$field} is required."
                    );
                }
            }
        }

        if (isset($data['user_id']) && (int)$data['user_id'] <= 0) {
            throw new InvalidArgumentException('Invalid user ID.');
        }

        if (isset($data['brand_id']) && (int)$data['brand_id'] <= 0) {
            throw new InvalidArgumentException('Invalid brand ID.');
        }

        if (isset($data['model']) && trim($data['model']) === '') {
            throw new InvalidArgumentException('Model cannot be empty.');
        }

        if (isset($data['year'])) {
            $year = (int)$data['year'];

            if ($year < 1886 || $year > ((int)date('Y') + 1)) {
                throw new InvalidArgumentException('Invalid car year.');
            }
        }

        if (isset($data['price'])) {
            if (!is_numeric($data['price']) || $data['price'] <= 0) {
                throw new InvalidArgumentException(
                    'Price must be greater than zero.'
                );
            }
        }
    }
}
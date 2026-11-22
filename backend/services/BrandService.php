<?php

require_once __DIR__ . '/../dao/BrandDAO.php';

class BrandService
{
    private BrandDAO $brandDAO;

    public function __construct()
    {
        $this->brandDAO = new BrandDAO();
    }

    public function getAllBrands(): array
    {
        return $this->brandDAO->getAll();
    }

    public function getBrandById(int $id): array
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid brand ID.');
        }

        $brand = $this->brandDAO->getById($id);

        if (!$brand) {
            throw new InvalidArgumentException('Brand not found.');
        }

        return $brand;
    }

    public function createBrand(array $data): string
    {
        $this->validateBrandData($data, true);

        return $this->brandDAO->create($data);
    }

    public function updateBrand(int $id, array $data): bool
    {
        $this->getBrandById($id);
        $this->validateBrandData($data, false);

        return $this->brandDAO->update($id, $data);
    }

    public function deleteBrand(int $id): bool
    {
        $this->getBrandById($id);

        return $this->brandDAO->delete($id);
    }

    private function validateBrandData(array $data, bool $isNew): void
    {
        if ($isNew && (
            !isset($data['brand_name']) ||
            trim($data['brand_name']) === ''
        )) {
            throw new InvalidArgumentException('Brand name is required.');
        }

        if (isset($data['brand_name']) && trim($data['brand_name']) === '') {
            throw new InvalidArgumentException('Brand name cannot be empty.');
        }

        if (isset($data['country']) && trim($data['country']) === '') {
            throw new InvalidArgumentException('Country cannot be empty.');
        }
    }
}
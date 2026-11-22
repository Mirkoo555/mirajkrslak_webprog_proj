<?php

require_once __DIR__ . '/../dao/UserDAO.php';

class UserService
{
    private UserDAO $userDAO;

    public function __construct()
    {
        $this->userDAO = new UserDAO();
    }

    public function getAllUsers(): array
    {
        return $this->userDAO->getAll();
    }

    public function getUserById(int $id): array
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid user ID.');
        }

        $user = $this->userDAO->getById($id);

        if (!$user) {
            throw new InvalidArgumentException('User not found.');
        }

        return $user;
    }

    public function createUser(array $data): string
    {
        $this->validateUserData($data, true);

        $data['password'] = password_hash(
            $data['password'],
            PASSWORD_DEFAULT
        );

        return $this->userDAO->create($data);
    }

    public function updateUser(int $id, array $data): bool
    {
        $this->getUserById($id);

        $this->validateUserData($data, false);

        if (isset($data['password'])) {
            $data['password'] = password_hash(
                $data['password'],
                PASSWORD_DEFAULT
            );
        }

        return $this->userDAO->update($id, $data);
    }

    public function deleteUser(int $id): bool
    {
        $this->getUserById($id);

        return $this->userDAO->delete($id);
    }

    private function validateUserData(array $data, bool $isNew): void
    {
        if ($isNew) {
            $requiredFields = [
                'full_name',
                'email',
                'password'
            ];

            foreach ($requiredFields as $field) {
                if (!isset($data[$field]) || trim((string)$data[$field]) === '') {
                    throw new InvalidArgumentException(
                        "Field {$field} is required."
                    );
                }
            }
        }

        if (isset($data['full_name']) && trim($data['full_name']) === '') {
            throw new InvalidArgumentException('Name cannot be empty.');
        }

        if (isset($data['email'])) {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new InvalidArgumentException('Invalid email address.');
            }
        }

        if (isset($data['password']) && strlen($data['password']) < 6) {
            throw new InvalidArgumentException(
                'Password must contain at least 6 characters.'
            );
        }

        if (isset($data['role'])) {
            if (!in_array($data['role'], ['user', 'admin'], true)) {
                throw new InvalidArgumentException('Invalid user role.');
            }
        }
    }
}
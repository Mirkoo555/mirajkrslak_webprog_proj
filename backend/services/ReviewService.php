<?php

require_once __DIR__ . '/../dao/ReviewDAO.php';

class ReviewService
{
    private ReviewDAO $reviewDAO;

    public function __construct()
    {
        $this->reviewDAO = new ReviewDAO();
    }

    public function getAllReviews(): array
    {
        return $this->reviewDAO->getAll();
    }

    public function getReviewById(int $id): array
    {
        $review = $this->reviewDAO->getById($id);

        if (!$review) {
            throw new InvalidArgumentException('Review not found.');
        }

        return $review;
    }

    public function createReview(array $data): string
    {
        $this->validateReview($data);

        return $this->reviewDAO->create($data);
    }

    public function updateReview(int $id, array $data): bool
    {
        $this->getReviewById($id);
        $this->validateReview($data);

        return $this->reviewDAO->update($id, $data);
    }

    public function deleteReview(int $id): bool
    {
        $this->getReviewById($id);

        return $this->reviewDAO->delete($id);
    }

    private function validateReview(array $data): void
    {
        if (
            !isset($data['user_id']) ||
            !is_numeric($data['user_id']) ||
            (int) $data['user_id'] <= 0
        ) {
            throw new InvalidArgumentException('Valid user_id is required.');
        }

        if (
            !isset($data['car_id']) ||
            !is_numeric($data['car_id']) ||
            (int) $data['car_id'] <= 0
        ) {
            throw new InvalidArgumentException('Valid car_id is required.');
        }

        if (
            !isset($data['rating']) ||
            !is_numeric($data['rating']) ||
            (int) $data['rating'] < 1 ||
            (int) $data['rating'] > 5 ||
            (float) $data['rating'] != (int) $data['rating']
        ) {
            throw new InvalidArgumentException('Rating must be an integer between 1 and 5.');
        }

        if (
            isset($data['comment']) &&
            !is_string($data['comment'])
        ) {
            throw new InvalidArgumentException('Comment must be a string.');
        }
    }
}
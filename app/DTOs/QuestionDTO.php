<?php

namespace App\DTOs;

class QuestionDTO
{
    /**
     * Create a new QuestionDTO instance.
     *
     * @param string|null $question
     * @param int|null $user_id
     * @param string|null $status
     */
    public function __construct(
        public readonly ?string $question,
        public readonly ?int $user_id = null,
        public readonly ?string $status = null,
    ) {

    }

    /**
     * Create a new QuestionDTO instance from an array.
     *
     * @param array<string|int> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            question: $data['question'] ?? '',
            user_id: $data['user_id'] ?? null,
            status: $data['status'] ?? null
        );
    }

    /**
     * Convert the QuestionDTO instance to an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'question' => $this->question,
            'user_id'  => $this->user_id,
            'status'   => $this->status,
        ];
    }
}

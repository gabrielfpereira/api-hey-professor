<?php

namespace App\DTOs;

class QuestionDTO
{


    public function __construct(
        public readonly ?string $question,
        public readonly ?int $user_id = null,
        public readonly ?string $status = null,
    )
    {

    }

    public static function fromArray(array $data): self
    {
        return new self(
            question: $data['question'] ?? '',
            user_id: $data['user_id'] ?? null,
            status: $data['status'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'question' => $this->question,
            'user_id' => $this->user_id,
            'status' => $this->status,
        ];
    }
}
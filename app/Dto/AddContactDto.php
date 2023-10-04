<?php

namespace App\Dto;

class AddContactDto
{
    public function __construct(
        public int $leadId,
        public string $name,
        public string $phone,
        public string $comment,
    ) {}
}

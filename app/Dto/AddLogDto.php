<?php

namespace App\Dto;

class AddLogDto
{
    use ToArray;
    public function __construct(
        public string $action,
        public bool $result,
    ) {}
}

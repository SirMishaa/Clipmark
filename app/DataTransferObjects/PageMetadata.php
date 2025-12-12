<?php

namespace App\DataTransferObjects;

readonly class PageMetadata
{
    public function __construct(
        public ?string $title,
        public ?string $description,
        public ?string $image = null,
        public ?string $siteName = null,
        public ?string $author = null,
    ) {}
}

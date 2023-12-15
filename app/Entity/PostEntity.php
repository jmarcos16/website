<?php

namespace App\Entity;

class PostEntity
{
    public ?string $title;

    public ?string $body = null;

    public ?string $created_at = null;

    public ?string $slug = null;

    public ?string $image = null;
}

<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class UniqueSlug extends Constraint
{
    public string $message = 'Le slug "{{ value }}" est déjà utilisé.';
    public string $mode = 'strict';

    // all configurable options must be passed to the constructor
    public function __construct(?string $mode = null, ?string $message = null, ?array $groups = null, $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->mode = $mode ?? $this->mode;
        $this->message = $message ?? $this->message;
    }
}

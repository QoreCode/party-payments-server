<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class EventMember extends Constraint
{
    public string $message = 'A member does not belong to the chosen event';
}

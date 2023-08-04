<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ExcludedMember extends Constraint
{
    public string $message = 'Member cannot be excluded from the payment';
}

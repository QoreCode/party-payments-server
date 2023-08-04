<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class MemberAndPayerSameEvent extends Constraint
{
    public string $message = 'Member and payer MUST be from the same event';
}

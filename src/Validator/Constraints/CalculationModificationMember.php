<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class CalculationModificationMember extends Constraint
{
    public string $message = 'Member cannot be added to calculation modification.';
}

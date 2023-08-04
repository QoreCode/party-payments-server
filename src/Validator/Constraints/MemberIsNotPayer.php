<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class MemberIsNotPayer extends Constraint
{
    public string $message = 'Member has been paid by another member and cannot be the payer';
}

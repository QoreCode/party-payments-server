<?php

namespace App\Validator\Constraints;

use App\Entity\Member;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MemberIsNotPayerValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        /** @var Member $member */
        $member = $this->context->getObject();

        if ($member->getPayer() && !empty($value->getValues())) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}

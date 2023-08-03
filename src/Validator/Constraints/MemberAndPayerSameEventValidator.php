<?php

namespace App\Validator\Constraints;

use App\Entity\Member;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MemberAndPayerSameEventValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        /** @var Member $member */
        $member = $this->context->getObject();
        /** @var Member $payedForMember */
        foreach ($value->getValues() as $payedForMember) {
            if ($member->getEvent()->getUid() !== $payedForMember->getEvent()->getUid()) {
                $this->context->buildViolation($constraint->message)->addViolation();
            }
        }
    }
}

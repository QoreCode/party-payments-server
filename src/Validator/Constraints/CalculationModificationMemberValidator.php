<?php

namespace App\Validator\Constraints;

use App\Entity\CalculationModification;
use App\Entity\Member;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CalculationModificationMemberValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint): void
    {
        /** @var CalculationModification $object */
        $object = $this->context->getObject();
        $calculationModificationEvent = $object->getPayment()->getEvent()->getUid();
        /** @var Member $member */
        foreach ($value->getValues() as $member) {
            if ($member->getEvent()->getUid() !== $calculationModificationEvent) {
                $this->context->buildViolation($constraint->message)->addViolation();
            }
        }
    }
}

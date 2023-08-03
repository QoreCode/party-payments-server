<?php

namespace App\Validator\Constraints;

use App\Entity\ExcludeModification;
use App\Entity\Member;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ExcludedMemberValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint): void
    {
        /** @var Member $value */
        /** @var ExcludeModification $object */
        $object = $this->context->getObject();

        if ($value && $value->getEvent()->getUid() !== $object->getPayment()->getEvent()->getUid()) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}

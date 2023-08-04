<?php /** @noinspection ALL */

namespace App\Validator\Constraints;

use App\Entity\ExcludeModification;
use App\Entity\Member;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ExcludedMemberValidator extends ConstraintValidator
{

    /**
     * @param Member $member
     * @param Constraint $constraint
     * @return void
     */
    public function validate($member, Constraint $constraint): void
    {
        /** @var ExcludeModification $excludeModification */
        $excludeModification = $this->context->getObject();

        if ($member->getEvent()->getUid() !== $excludeModification->getPayment()->getEvent()->getUid()) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}

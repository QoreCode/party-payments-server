<?php /** @noinspection ALL */

namespace App\Validator\Constraints;

use App\Entity\CalculationModification;
use App\Entity\Member;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CalculationModificationMemberValidator extends ConstraintValidator
{
    /**
     * @param Collection<int, Member> $membersCollection
     * @param Constraint $constraint
     * @return void
     */
    public function validate($membersCollection, Constraint $constraint): void
    {
        /** @var CalculationModification $object */
        $object = $this->context->getObject();
        $calculationModificationEventUid = $object->getPayment()->getEvent()->getUid();
        /** @var Member $member */
        foreach ($membersCollection->getValues() as $member) {
            if ($member->getEvent()->getUid() !== $calculationModificationEventUid) {
                $this->context->buildViolation($constraint->message)->addViolation();
            }
        }
    }
}

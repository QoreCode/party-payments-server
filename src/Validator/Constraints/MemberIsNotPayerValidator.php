<?php /** @noinspection ALL */

namespace App\Validator\Constraints;

use App\Entity\Member;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MemberIsNotPayerValidator extends ConstraintValidator
{
    /**
     * @param Collection<int, Member> $membersCollection
     * @param Constraint $constraint
     * @return void
     */
    public function validate($membersCollection, Constraint $constraint): void
    {
        /** @var Member $member */
        $member = $this->context->getObject();
        if ($member->getPayer() && !empty($membersCollection->getValues())) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}

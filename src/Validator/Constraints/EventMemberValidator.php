<?php /** @noinspection ALL */

namespace App\Validator\Constraints;

use App\Entity\Member;
use App\Entity\PartyEvent;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EventMemberValidator extends ConstraintValidator
{
    /**
     * @param Member $member
     * @param Constraint $constraint
     * @return void
     */
    public function validate($member, Constraint $constraint): void
    {
        if (!$member) {
            return;
        }

        /** @var PartyEvent $event */
        $event = $this->context->getObject()->getEvent();
        if ($event->getUid() !== $member->getEvent()->getUid()) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}

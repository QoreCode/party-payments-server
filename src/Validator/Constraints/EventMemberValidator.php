<?php

namespace App\Validator\Constraints;

use App\Entity\Member;
use App\Entity\PartyEvent;
use App\Repository\MemberRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EventMemberValidator extends ConstraintValidator
{
    public function __construct(private readonly MemberRepository $memberRepository)
    {
    }

    public function validate($value, Constraint $constraint): void
    {
        $object = $this->context->getObject();
        /** @var PartyEvent $event */
        $event = $this->context->getObject()->getEvent();
        /** @var Member $value */
        if ($value && $event->getUid() !== $value->getEvent()->getUid()) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}

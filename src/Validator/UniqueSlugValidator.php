<?php

namespace App\Validator;

use App\Entity\MusicDetail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueSlugValidator extends ConstraintValidator
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) { }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof UniqueSlug) {
            throw new UnexpectedTypeException($constraint, UniqueSlug::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) {
            return;
        }

        $musicDetail = $this->entityManager->getRepository(MusicDetail::class)->findOneBy(['slug' => $value]);
        // Get back entity in order to ensure that slug is not use by ANOTHER entity
        $entity = $this->context->getObject()->getParent()->getData();

        // No MusicDetail found : ignore validator
        if ($musicDetail === null) {
            return;
        }

        // MusicDetail found and current entity are the same : ignore validator
        if ($musicDetail->getId() === $entity->getId()) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}

<?php

namespace App\Serializer;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Serializer\ItemNormalizer;
use App\Entity\ExcludeModification;
use App\Entity\Member;
use App\Entity\Payment;

class Normalizer extends ItemNormalizer
{
/*    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof Payment
            || $data instanceof Member
            || $data instanceof ExcludeModification;
    }*/

    protected function normalizeRelation(
        ApiProperty $propertyMetadata,
        ?object $relatedObject,
        string $resourceClass,
        ?string $format,
        array $context
    ): \ArrayObject|array|string|null {
        $data = parent::normalizeRelation($propertyMetadata, $relatedObject, $resourceClass, $format,
            $context);
        if (is_array($data)) {
            return $data['uid'];
        }

        return is_null($data) ? [] : $this->iriConverter->getResourceFromIri($data)->getUid();
    }

    protected function normalizeCollectionOfRelations(
        ApiProperty $propertyMetadata,
        iterable $attributeValue,
        string $resourceClass,
        ?string $format,
        array $context
    ): array {
        $value = [];
        foreach ($attributeValue as $index => $obj) {
            if (!\is_object($obj) && null !== $obj) {
                /*CUSTOM: return empty array instead of Exception*/
                return [];
            }

            $objResourceClass = $this->resourceClassResolver->getResourceClass($obj, $resourceClass);
            $context['resource_class'] = $objResourceClass;
            if ($this->resourceMetadataCollectionFactory) {
                $context['operation'] = $this->resourceMetadataCollectionFactory->create($objResourceClass)
                    ->getOperation();
            }
            $value[$index] = $this->normalizeRelation($propertyMetadata, $obj, $resourceClass, $format, $context);
        }

        return $value;
    }

    protected function denormalizeRelation(
        string $attributeName,
        ApiProperty $propertyMetadata,
        string $className,
        mixed $value,
        ?string $format,
        array $context
    ): ?object {
        if (\is_string($value)) {
            $value = $this->iriConverter->getIriFromResource(
                resource: $className,
                context: ['uri_variables' => ['uid' => $value]]);
        }

        return parent::denormalizeRelation($attributeName, $propertyMetadata, $className, $value, $format, $context);

    }

}

<?php

namespace JMS\Serializer\Exclusion;


use JMS\Serializer\Context;
use JMS\Serializer\Metadata\ClassMetadata;
use JMS\Serializer\Metadata\PropertyMetadata;

class ConjunctiveExclusionStrategy extends AbstractBaseExclusionStrategy
{
    /**
     * {@inheritdoc}
     */
    public function shouldSkipClass(ClassMetadata $metadata, Context $context)
    {
        foreach ($this->delegates as $delegate) {
            /** @var $delegate ExclusionStrategyInterface */
            if (false == $delegate->shouldSkipClass($metadata, $context)) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function shouldSkipProperty(PropertyMetadata $property, Context $context)
    {
        foreach ($this->delegates as $delegate) {
            /** @var $delegate ExclusionStrategyInterface */
            if (false == $delegate->shouldSkipProperty($property, $context)) {
                return false;
            }
        }

        return true;
    }

}
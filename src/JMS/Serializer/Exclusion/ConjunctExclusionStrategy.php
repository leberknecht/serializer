<?php

namespace JMS\Serializer\Exclusion;


use JMS\Serializer\Metadata\PropertyMetadata;
use PhpCollection\SequenceInterface;

class ConjunctExclusionStrategy
{
    /** @var SequenceInterface */
    private $delegates;

    /**
     * @param ExclusionStrategyInterface[]|SequenceInterface $delegates
     */
    public function __construct($delegates)
    {
        if ( ! $delegates instanceof SequenceInterface) {
            $delegates = new Sequence($delegates);
        }

        $this->delegates = $delegates;
    }

    public function addStrategy(ExclusionStrategyInterface $strategy)
    {
        $this->delegates->add($strategy);
    }

    /**
     * Whether the class should be skipped.
     *
     * @param ClassMetadata $metadata
     *
     * @return boolean
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
     * Whether the property should be skipped.
     *
     * @param PropertyMetadata $property
     *
     * @return boolean
     */
    public function shouldSkipProperty(PropertyMetadata $property, Context $context)
    {
        foreach ($this->delegates as $delegate) {
            /** @var $delegate ExclusionStrategyInterface */
            if ($delegate->shouldSkipProperty($property, $context)) {
                return true;
            }
        }

        return false;
    }

}
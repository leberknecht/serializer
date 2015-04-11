<?php

namespace JMS\Serializer\Exclusion;


use JMS\Serializer\Context;
use JMS\Serializer\Metadata\ClassMetadata;
use JMS\Serializer\Metadata\PropertyMetadata;
use PhpCollection\Sequence;
use PhpCollection\SequenceInterface;

abstract class AbstractBaseExclusionStrategy implements ExclusionStrategyInterface
{
    /** @var SequenceInterface */
    protected $delegates;

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
     * @param Context $context
     * @return bool
     */
    abstract public function shouldSkipClass(ClassMetadata $metadata, Context $context);

    /**
     * Whether the property should be skipped.
     *
     * @param PropertyMetadata $property
     *
     * @param Context $context
     * @return bool
     */
    abstract public function shouldSkipProperty(PropertyMetadata $property, Context $context);
}
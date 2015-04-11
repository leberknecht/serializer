<?php

namespace JMS\Serializer\Exclusion;

use JMS\Serializer\Exception\LogicException;
use PhpCollection\SequenceInterface;

class ExclusionStrategyFactory
{
    const EXCLUSION_LOGIC_DISJUNCTION = 'disjunctive';
    const EXCLUSION_LOGIC_CONJUNCTION = 'conjunctive';

    /**
     * @param string $exclusionLogic
     * @param ExclusionStrategyInterface $delegates
     * @return AbstractBaseExclusionStrategy
     * @throws LogicException
     */
    public static function createBaseExclusionStrategy($exclusionLogic, ExclusionStrategyInterface $delegates)
    {
        switch ($exclusionLogic) {
            case static::EXCLUSION_LOGIC_CONJUNCTION :
                return new ConjunctiveExclusionStrategy($delegates);
                break;
            case static::EXCLUSION_LOGIC_DISJUNCTION :
                return new DisjunctiveExclusionStrategy($delegates);
                break;
            default:
                throw new LogicException('unsupported logic type specified');
        }
    }
}
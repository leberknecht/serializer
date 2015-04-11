<?php

namespace JMS\Serializer\Tests\Exclusion;

use JMS\Serializer\Exclusion\ExclusionStrategyFactory;
use JMS\Serializer\Exclusion\VersionExclusionStrategy;

class ExclusionStrategyFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateBaseExclusionDisjunctive()
    {
        $versionExclusionStrategy = new VersionExclusionStrategy('0.1');
        $strategy = ExclusionStrategyFactory::createBaseExclusionStrategy(
            ExclusionStrategyFactory::EXCLUSION_LOGIC_DISJUNCTION,
            $versionExclusionStrategy
        );

        $this->assertInstanceOf('JMS\Serializer\Exclusion\DisjunctiveExclusionStrategy', $strategy);
    }

    public function testCreateBaseExclusionConjunctive()
    {
        $versionExclusionStrategy = new VersionExclusionStrategy('0.1');
        $strategy = ExclusionStrategyFactory::createBaseExclusionStrategy(
            ExclusionStrategyFactory::EXCLUSION_LOGIC_CONJUNCTION,
            $versionExclusionStrategy
        );

        $this->assertInstanceOf('JMS\Serializer\Exclusion\ConjunctiveExclusionStrategy', $strategy);
    }

    public function testCreateBaseExclusionExceptionOnUnknown()
    {
        $versionExclusionStrategy = new VersionExclusionStrategy('0.1');
        $this->setExpectedException('LogicException');
        ExclusionStrategyFactory::createBaseExclusionStrategy(
            'unknownLogic',
            $versionExclusionStrategy
        );
    }
}
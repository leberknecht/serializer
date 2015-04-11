<?php

/*
 * Copyright 2013 Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace JMS\Serializer\Tests\Exclusion;

use JMS\Serializer\Exclusion\ConjunctiveExclusionStrategy;
use JMS\Serializer\Exclusion\DisjunctiveExclusionStrategy;
use JMS\Serializer\Metadata\ClassMetadata;
use JMS\Serializer\Metadata\StaticPropertyMetadata;
use JMS\Serializer\SerializationContext;

class ConjunctiveExclusionStrategyTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldSkipClassShortCircuiting()
    {
        $metadata = new ClassMetadata('stdClass');
        $context = SerializationContext::create();

        $strat = new ConjunctiveExclusionStrategy(array(
            $first = $this->getMock('JMS\Serializer\Exclusion\ExclusionStrategyInterface'),
            $last = $this->getMock('JMS\Serializer\Exclusion\ExclusionStrategyInterface'),
        ));

        $first->expects($this->once())
            ->method('shouldSkipClass')
            ->with($metadata, $context)
            ->will($this->returnValue(false));

        $last->expects($this->never())
            ->method('shouldSkipClass');

        $this->assertFalse($strat->shouldSkipClass($metadata, $context));
    }

    public function testShouldSkipClassConjunctiveBehavior()
    {
        $metadata = new ClassMetadata('stdClass');
        $context = SerializationContext::create();

        $strat = new ConjunctiveExclusionStrategy(array(
            $first = $this->getMock('JMS\Serializer\Exclusion\ExclusionStrategyInterface'),
            $last = $this->getMock('JMS\Serializer\Exclusion\ExclusionStrategyInterface'),
        ));

        $first->expects($this->once())
            ->method('shouldSkipClass')
            ->with($metadata, $context)
            ->will($this->returnValue(true));

        $last->expects($this->once())
            ->method('shouldSkipClass')
            ->with($metadata, $context)
            ->will($this->returnValue(false));

        $this->assertFalse($strat->shouldSkipClass($metadata, $context));
    }

    public function testShouldSkipClassReturnsTrueOnFirstFalse()
    {
        $metadata = new ClassMetadata('stdClass');
        $context = SerializationContext::create();

        $strat = new ConjunctiveExclusionStrategy(array(
            $first = $this->getMock('JMS\Serializer\Exclusion\ExclusionStrategyInterface'),
            $last = $this->getMock('JMS\Serializer\Exclusion\ExclusionStrategyInterface'),
        ));

        $first->expects($this->once())
            ->method('shouldSkipClass')
            ->with($metadata, $context)
            ->will($this->returnValue(false));

        $last->expects($this->never())
            ->method('shouldSkipClass');

        $this->assertFalse($strat->shouldSkipClass($metadata, $context));
    }

    public function testShouldSkipPropertyShortCircuiting()
    {
        $metadata = new StaticPropertyMetadata('stdClass', 'foo', 'bar');
        $context = SerializationContext::create();

        $strat = new ConjunctiveExclusionStrategy(array(
            $first = $this->getMock('JMS\Serializer\Exclusion\ExclusionStrategyInterface'),
            $last = $this->getMock('JMS\Serializer\Exclusion\ExclusionStrategyInterface'),
        ));

        $first->expects($this->once())
            ->method('shouldSkipProperty')
            ->with($metadata, $context)
            ->will($this->returnValue(false));

        $last->expects($this->never())
            ->method('shouldSkipProperty');

        $this->assertFalse($strat->shouldSkipProperty($metadata, $context));
    }

    public function testShouldSkipPropertyConjunct()
    {
        $metadata = new StaticPropertyMetadata('stdClass', 'foo', 'bar');
        $context = SerializationContext::create();

        $strat = new DisjunctiveExclusionStrategy(array(
            $first = $this->getMock('JMS\Serializer\Exclusion\ExclusionStrategyInterface'),
            $last = $this->getMock('JMS\Serializer\Exclusion\ExclusionStrategyInterface'),
        ));

        $first->expects($this->once())
            ->method('shouldSkipProperty')
            ->with($metadata, $context)
            ->will($this->returnValue(true));

        $last->expects($this->once())
            ->method('shouldSkipProperty')
            ->with($metadata, $context)
            ->will($this->returnValue(false));

        $this->assertFalse($strat->shouldSkipProperty($metadata, $context));
    }

    public function testShouldSkipPropertyReturnsFalseIfNoPredicateMatches()
    {
        $metadata = new StaticPropertyMetadata('stdClass', 'foo', 'bar');
        $context = SerializationContext::create();

        $strat = new ConjunctiveExclusionStrategy(array(
            $first = $this->getMock('JMS\Serializer\Exclusion\ExclusionStrategyInterface'),
            $last = $this->getMock('JMS\Serializer\Exclusion\ExclusionStrategyInterface'),
        ));

        $first->expects($this->once())
            ->method('shouldSkipProperty')
            ->with($metadata, $context)
            ->will($this->returnValue(false));

        $last->expects($this->never())
            ->method('shouldSkipProperty');

        $this->assertFalse($strat->shouldSkipProperty($metadata, $context));
    }
}

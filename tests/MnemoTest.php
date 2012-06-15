<?php

namespace Blendwerk\Mnemo\Tests;

use Blendwerk\Mnemo\Mnemo;

class MnemoTest extends \PhpUnit_Framework_TestCase
{
    /**
     * @covers Blendwerk\Mnemo\Mnemo::fromInteger
     */
    public function testFromInteger()
    {
        $this->assertEquals('nada', Mnemo::fromInteger(2455));
        $this->assertEquals('haruka', Mnemo::fromInteger(76955));
        $this->assertEquals('karasu', Mnemo::fromInteger(125704));
        $this->assertEquals('kazuma', Mnemo::fromInteger(127010));
        $this->assertEquals('kotoba', Mnemo::fromInteger(141260));
        $this->assertEquals('takeshimaya', Mnemo::fromInteger(1329724967));
        $this->assertEquals('dobejotehotzu', Mnemo::fromInteger(13477774722));
        $this->assertEquals('winamote', Mnemo::fromInteger(-173866));
        $this->assertEquals('wina', Mnemo::fromInteger(-35));
    }

    /**
     * @covers Blendwerk\Mnemo\Mnemo::toInteger
     */
    public function testToInteger()
    {
        $this->assertEquals(2455, Mnemo::toInteger('nada'));
        $this->assertEquals(76955, Mnemo::toInteger('haruka'));
        $this->assertEquals(125704, Mnemo::toInteger('karasu'));
        $this->assertEquals(127010, Mnemo::toInteger('kazuma'));
        $this->assertEquals(141260, Mnemo::toInteger('kotoba'));
        $this->assertEquals(1329724967, Mnemo::toInteger('takeshimaya'));
        $this->assertEquals(13477774722, Mnemo::toInteger('dobejotehotzu'));
        $this->assertEquals(-173866, Mnemo::toInteger('winamote'));
        $this->assertEquals(-35, Mnemo::toInteger('wina'));
    }

    /**
     * @covers Blendwerk\Mnemo\Mnemo::toInteger
     * @covers Blendwerk\Mnemo\Mnemo::toNumber
     * @expectedException UnexpectedValueException
     */
    public function testToIntegerUnexpectedValueException()
    {
        $this->setExpectedException('UnexpectedValueException');
        Mnemo::toInteger('rstuvwxyz');
    }

    /**
     * @covers Blendwerk\Mnemo\Mnemo::split
     */
    public function testSplit()
    {
        $this->assertEquals(array('tsu', 'na', 'shi', 'ma'),
            Mnemo::split('tsunashima'));
    }

    /**
     * @covers Blendwerk\Mnemo\Mnemo::split
     *
     * @expectedException UnexpectedValueException
     */
    public function testSplitUnexpectedValueException()
    {
        $this->assertEquals(array('tsu', 'na', 'shi', 'ma'),
            Mnemo::split('abcdefgh'));
    }

    /**
     * @covers Blendwerk\Mnemo\Mnemo::isMnemoWord
     */
    public function testIsMnemoWord()
    {
        $this->assertTrue(Mnemo::isMnemoWord('fugu'));
        $this->assertTrue(Mnemo::isMnemoWord('kazuma'));
        $this->assertTrue(Mnemo::isMnemoWord('toriyamanobashi'));
        $this->assertFalse(Mnemo::isMnemoWord('George'));
        $this->assertFalse(Mnemo::isMnemoWord('abcdefgh'));
        $this->assertFalse(Mnemo::isMnemoWord('ijklmnopq'));
    }

    /**
     * @covers Blendwerk\Mnemo\Mnemo::fromInteger
     * @covers Blendwerk\Mnemo\Mnemo::toInteger
     */
    public function testZero()
    {
        $this->assertEquals('', Mnemo::fromInteger(0));
        $this->assertEquals(0, Mnemo::toInteger(''));
    }
}

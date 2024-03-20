<?php

namespace Tests\Unit;

use Codeception\Test\Unit;
use JetBrains\PhpStorm\NoReturn;
use StrannyiTip\Helper\Type\Exception\IndexIsNotInteger;
use StrannyiTip\Helper\Type\SimpleString;
use StrannyiTip\Helper\Type\StringList;

class StringListTest extends Unit
{
    private StringList $list;

    public function _before(): void
    {
        $this->list = new StringList(new SimpleString('nature is amazing'));
    }
    public function testOffsetSet()
    {
        $this->list[555] = 'lucky number';
        $this->assertInstanceOf(SimpleString::class, $this->list[555], 'Check for list item is a SimpleString object');
        $this->assertEquals('lucky number', $this->list[555], 'Check for item is setted');
        unset($this->list[555]);
    }

    #[NoReturn] public function test__construct()
    {
        $test_list = new StringList(new SimpleString('a'), new SimpleString('b'));
        $this->assertEquals(new SimpleString('nature is amazing'), $this->list[0]);
        $this->assertEquals('a', $test_list[0], 'Check for access item for key');
        $this->assertEquals('b', $test_list[1], 'Check for access item for key');
        $this->assertCount(2, $test_list, 'Check for countability');
        $string_list = new StringList('one', 'two', 'three');
        $this->assertCount(3, $string_list, 'Check for countability');
        $this->assertInstanceOf(SimpleString::class, $string_list[0], 'Check for item is a SimpleString');
        $this->assertInstanceOf(SimpleString::class, $string_list[1], 'Check for item is a SimpleString');
        $this->assertInstanceOf(SimpleString::class, $string_list[2], 'Check for item is a SimpleString');
        $this->assertEquals('one', $string_list[0], 'Check for setter work correctly');
        $this->assertEquals('two', $string_list[1], 'Check for setter work correctly');
        $this->assertEquals('three', $string_list[2], 'Check for setter work correctly');
    }

    public function testOffsetGet()
    {
        $string_list = new StringList('one', 'two');
        $this->assertCount(2, $string_list, 'Check for countability');
        $this->assertInstanceOf(SimpleString::class, $string_list[0], 'Check for item is a SimpleString');
        $this->assertInstanceOf(SimpleString::class, $string_list[1], 'Check for item is a SimpleString');
        $this->assertEquals('one', $string_list[0], 'Check for setter work correctly');
        $this->assertEquals('two', $string_list[1], 'Check for setter work correctly');
    }

    public function testOffsetUnset()
    {
        $string_list = new StringList('one', 'two');
        $this->assertCount(2, $string_list, 'Check for count is 2');
        unset($string_list[0]);
        $this->assertCount(1, $string_list, 'Check for count is 1: item removed');
    }

    public function testOffsetExists()
    {
        $string_list = new StringList('one', 'two', new SimpleString('three'));
        $string_list[3] = new SimpleString('four');
        $this->assertTrue(isset ($string_list[0]), 'Check for 0 item is present');
        $this->assertTrue(isset($string_list[1]), 'Check for 1 item is present');
        $this->assertTrue(isset($string_list[2]), 'Check for 2 item is present');
        $this->assertTrue(isset($string_list[3]), 'Check for 3 item is present');
    }

    public function testException()
    {
        $list = new StringList();
        $this->expectException(IndexIsNotInteger::class);
        $list['a'] = 1;
    }
}

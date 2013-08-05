<?php

class StringCalculatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var StringCalculator
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new StringCalculator();
    }

    protected function tearDown()
    {
        $this->object = null;
    }

    public function shouldReturnTheSumOfZeroToAnyNumbersDataProvider()
    {
        return array(
            array(0, ''),
            array(1, '1'),
            array(3, '1,2')
        );
    }

    /**
     * @test
     * @dataProvider shouldReturnTheSumOfZeroToAnyNumbersDataProvider
     */
    public function shouldReturnTheSumOfZeroToAnyNumbers($expected, $operands)
    {
        $this->assertSame($expected, $this->object->add($operands));
    }

    public function shouldReturnTheSumOfTheNumbersInTheStringSeparatedByACommaOrACarriageReturnDataProvider()
    {
        return array(
            array(5, "1,2\n2"),
            array(6, "1\n2,3")
        );
    }

    /**
     * @test
     * @dataProvider shouldReturnTheSumOfTheNumbersInTheStringSeparatedByACommaOrACarriageReturnDataProvider
     */
    public function shouldReturnTheSumOfTheNumbersInTheStringSeparatedByACommaOrACarriageReturn($expected, $operands)
    {
        $this->assertSame($expected, $this->object->add($operands));
    }

    public function should_support_delimitier_definition_specified_in_the_first_line_of_the_string_data_provider()
    {
        return array(
            array(3, "//[;]\n1;2"),
            array(6, "//[,]\n1,2,3"),
            array(6, "//[***]\n1***2***3"),
            array(6, "//[*][%]\n1*2%3"),
            array(6, "//[**][%]%\n1**2%%3"),
        );
    }

    /**
     * @test
     * @dataProvider should_support_delimitier_definition_specified_in_the_first_line_of_the_string_data_provider
     */
    public function should_support_delimiters_of_any_length($expected, $operands)
    {
        $this->assertSame($expected, $this->object->add($operands));
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage negatives not allowed
     */
    public function should_not_support_negative_numbers()
    {
        $this->object->add('-1');
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage negatives not allowed: -1, -2
     */
    public function should_not_support_negatives_numbers_and_when_more_than_one_found_should_show_them()
    {
        $this->object->add('-1,-2');
    }

    /**
     * @test
     */
    public function should_not_support_numbers_bigger_than_1000()
    {
        $this->assertEquals(1002, $this->object->add('2,1000'));
        $this->assertEquals(2, $this->object->add('2,1001'));
    }
}
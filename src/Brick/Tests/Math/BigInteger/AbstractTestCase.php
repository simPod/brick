<?php

namespace Brick\Tests\Math\BigInteger;

use Brick\Math\ArithmeticException;
use Brick\Math\Calculator;
use Brick\Math\BigInteger;
use Brick\Math\RoundingMode;

/**
 * Unit tests for class Decimal.
 */
abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \Brick\Math\Calculator
     */
    abstract public function getCalculator();

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        Calculator::set($this->getCalculator());
    }

    /**
     * @param BigInteger|string $expected
     * @param BigInteger|string $actual
     */
    private function assertBigIntegerEquals($expected, $actual)
    {
        $message = sprintf('Expected %s, got %s', $expected, $actual);
        $this->assertTrue(BigInteger::of($actual)->isEqualTo($expected), $message);
    }

    /**
     * @dataProvider providerShiftedLeft
     *
     * @param string  $number   The number to shift.
     * @param integer $bits     The number of bits to shift.
     * @param string  $expected The expected result.
     */
    public function testShiftedLeft($number, $bits, $expected)
    {
        $this->assertBigIntegerEquals($expected, BigInteger::of($number)->shiftedLeft($bits));
    }

    /**
     * @return array
     */
    public function providerShiftedLeft()
    {
        return [
            ['1',  0, '1'],
            ['1',  1, '2'],
            ['1', 63, '9223372036854775808'],
            ['1', 64, '18446744073709551616'],
            ['1', 65, '36893488147419103232'],

            ['3',   0, '3'],
            ['3',   1, '6'],
            ['3', 127, '510423550381407695195061911147652317184'],
            ['3', 128, '1020847100762815390390123822295304634368'],
            ['3', 129, '2041694201525630780780247644590609268736'],

            ['-1',  0, '-1'],
            ['-1',  1, '-2'],
            ['-1', 63, '-9223372036854775808'],
            ['-1', 64, '-18446744073709551616'],
            ['-1', 65, '-36893488147419103232'],

            ['-3',   0, '-3'],
            ['-3',   1, '-6'],
            ['-3', 127, '-510423550381407695195061911147652317184'],
            ['-3', 128, '-1020847100762815390390123822295304634368'],
            ['-3', 129, '-2041694201525630780780247644590609268736'],

            ['42', 0, '42'],
            ['42', 1, '84'],
            ['42', 2, '168'],
            ['42', 10, '43008'],
            ['42', 20, '44040192'],
            ['42', 100, '53241325209585634862861534625792'],
            ['42', 200, '67491397858877591572762407878328829305932525738877299082657792'],

            ['-42', 0, '-42'],
            ['-42', 1, '-84'],
            ['-42', 2, '-168'],
            ['-42', 10, '-43008'],
            ['-42', 20, '-44040192'],
            ['-42', 100, '-53241325209585634862861534625792'],
            ['-42', 200, '-67491397858877591572762407878328829305932525738877299082657792'],

            ['123456789123456789123456789', 0, '123456789123456789123456789'],
            ['123456789123456789123456789', 1, '246913578246913578246913578'],
            ['123456789123456789123456789', 2, '493827156493827156493827156'],
            ['123456789123456789123456789', 3, '987654312987654312987654312'],
            ['123456789123456789123456789', 10, '126419752062419752062419751936'],
            ['123456789123456789123456789', 20, '129453826111917826111917825982464'],
            ['123456789123456789123456789', 30, '132560717938603853938603853806043136'],
            ['123456789123456789123456789', 100, '156500072834599941898774713564003138549903269485728497664'],

            ['-123456789123456789123456789', 0, '-123456789123456789123456789'],
            ['-123456789123456789123456789', 1, '-246913578246913578246913578'],
            ['-123456789123456789123456789', 2, '-493827156493827156493827156'],
            ['-123456789123456789123456789', 3, '-987654312987654312987654312'],
            ['-123456789123456789123456789', 10, '-126419752062419752062419751936'],
            ['-123456789123456789123456789', 20, '-129453826111917826111917825982464'],
            ['-123456789123456789123456789', 30, '-132560717938603853938603853806043136'],
            ['-123456789123456789123456789', 100, '-156500072834599941898774713564003138549903269485728497664'],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testShiftedLeftThrowsExceptionWhenBitsIsNegative()
    {
        BigInteger::of(1)->shiftedLeft(-1);
    }

    /**
     * @dataProvider providerShiftedRight
     *
     * @param string  $number   The number to shift.
     * @param integer $bits     The number of bits to shift.
     * @param string  $expected The expected result.
     */
    public function testShiftedRight($number, $bits, $expected)
    {
        $this->assertBigIntegerEquals($expected, BigInteger::of($number)->shiftedRight($bits));
    }

    /**
     * @return array
     */
    public function providerShiftedRight()
    {
        return [
            ['1', 0, '1'],
            ['1', 1, '0'],
            ['1', 10, '0'],
            ['1', 1000, '0'],

            ['-1', 0, '-1'],
            ['-1', 1, '-1'],
            ['-1', 10, '-1'],
            ['-1', 1000, '-1'],

            ['42', 0, '42'],
            ['42', 1, '21'],
            ['42', 2, '10'],
            ['42', 3, '5'],
            ['42', 4, '2'],
            ['42', 5, '1'],
            ['42', 6, '0'],
            ['42', 7, '0'],

            ['-42', 0, '-42'],
            ['-42', 1, '-21'],
            ['-42', 2, '-11'],
            ['-42', 3, '-6'],
            ['-42', 4, '-3'],
            ['-42', 5, '-2'],
            ['-42', 6, '-1'],
            ['-42', 7, '-1'],

            ['42', 0, '42'],
            ['42', 1, '21'],
            ['42', 2, '10'],
            ['42', 3, '5'],
            ['42', 4, '2'],
            ['42', 5, '1'],
            ['42', 6, '0'],
            ['42', 7, '0'],

            ['-42', 0, '-42'],
            ['-42', 1, '-21'],
            ['-42', 2, '-11'],
            ['-42', 3, '-6'],
            ['-42', 4, '-3'],
            ['-42', 5, '-2'],
            ['-42', 6, '-1'],
            ['-42', 7, '-1'],

            ['3640', 0, '3640'],
            ['3640', 1, '1820'],
            ['3640', 2, '910'],
            ['3640', 3, '455'],
            ['3640', 4, '227'],
            ['3640', 5, '113'],
            ['3640', 6, '56'],
            ['3640', 7, '28'],
            ['3640', 8, '14'],
            ['3640', 9, '7'],
            ['3640', 10, '3'],
            ['3640', 11, '1'],
            ['3640', 12, '0'],
            ['3640', 13, '0'],

            ['-3640', 0, '-3640'],
            ['-3640', 1, '-1820'],
            ['-3640', 2, '-910'],
            ['-3640', 3, '-455'],
            ['-3640', 4, '-228'],
            ['-3640', 5, '-114'],
            ['-3640', 6, '-57'],
            ['-3640', 7, '-29'],
            ['-3640', 8, '-15'],
            ['-3640', 9, '-8'],
            ['-3640', 10, '-4'],
            ['-3640', 11, '-2'],
            ['-3640', 12, '-1'],
            ['-3640', 13, '-1'],

            ['123456789123456789123456789', 0, '123456789123456789123456789'],
            ['123456789123456789123456789', 1, '61728394561728394561728394'],
            ['123456789123456789123456789', 2, '30864197280864197280864197'],
            ['123456789123456789123456789', 3, '15432098640432098640432098'],
            ['123456789123456789123456789', 4, '7716049320216049320216049'],
            ['123456789123456789123456789', 5, '3858024660108024660108024'],
            ['123456789123456789123456789', 10, '120563270628375770628375'],
            ['123456789123456789123456789', 20, '117737568973023213504'],
            ['123456789123456789123456789', 30, '114978094700217981'],
            ['123456789123456789123456789', 40, '112283295605681'],
            ['123456789123456789123456789', 50, '109651655864'],
            ['123456789123456789123456789', 80, '102'],
            ['123456789123456789123456789', 81, '51'],
            ['123456789123456789123456789', 82, '25'],
            ['123456789123456789123456789', 83, '12'],
            ['123456789123456789123456789', 84, '6'],
            ['123456789123456789123456789', 85, '3'],
            ['123456789123456789123456789', 86, '1'],
            ['123456789123456789123456789', 87, '0'],
            ['123456789123456789123456789', 88, '0'],

            ['-123456789123456789123456789', 0, '-123456789123456789123456789'],
            ['-123456789123456789123456789', 1, '-61728394561728394561728395'],
            ['-123456789123456789123456789', 2, '-30864197280864197280864198'],
            ['-123456789123456789123456789', 3, '-15432098640432098640432099'],
            ['-123456789123456789123456789', 4, '-7716049320216049320216050'],
            ['-123456789123456789123456789', 5, '-3858024660108024660108025'],
            ['-123456789123456789123456789', 10, '-120563270628375770628376'],
            ['-123456789123456789123456789', 20, '-117737568973023213505'],
            ['-123456789123456789123456789', 30, '-114978094700217982'],
            ['-123456789123456789123456789', 40, '-112283295605682'],
            ['-123456789123456789123456789', 50, '-109651655865'],
            ['-123456789123456789123456789', 80, '-103'],
            ['-123456789123456789123456789', 81, '-52'],
            ['-123456789123456789123456789', 82, '-26'],
            ['-123456789123456789123456789', 83, '-13'],
            ['-123456789123456789123456789', 84, '-7'],
            ['-123456789123456789123456789', 85, '-4'],
            ['-123456789123456789123456789', 86, '-2'],
            ['-123456789123456789123456789', 87, '-1'],
            ['-123456789123456789123456789', 88, '-1'],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testShiftedRightThrowsExceptionWhenBitsIsNegative()
    {
        BigInteger::of(1)->shiftedRight(-1);
    }
}

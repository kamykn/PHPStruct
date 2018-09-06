<?php

namespace StructTest;

use PHPUnit\Framework\TestCase;
use StructTest\SampleStruct;
use StructTest\SampleMethodStruct;

/**
 * Class CollectionTest
 * @package CollectionTest
 */
class StructTest extends TestCase
{
	/**
	 * @test
	 */
	public function testWrongType()
	{
		$sampleStruct = new SampleStruct([
			'typeInt' => 10,
		]);

		$e = null;
		try {
			$sampleStruct->typeInt = 'string';
		} catch (\Exception $e) {
		}
		$msg = 'Trying to set a different type. Property "typeInt" is [integer] type.';
		$this->assertInstanceOf('\Exception', $e);
		$this->assertEquals($msg, $e->getMessage());
	}

	/**
	 * @test
	 */
	public function testInt()
	{
		$sampleStruct = new SampleStruct([
			'typeInt' => 10,
		]);
		$this->assertSame(10, $sampleStruct->typeInt);

		$sampleStruct->typeInt = 1;
		$this->assertSame(1, $sampleStruct->typeInt);

		$sampleStruct->typeInt = -123;
		$this->assertSame(-123, $sampleStruct->typeInt);

		$sampleStruct->typeInt = 0123; // 8進数
		$this->assertSame(0123, $sampleStruct->typeInt);

		$sampleStruct->typeInt = 0x1A; // 16進数
		$this->assertSame(0x1A, $sampleStruct->typeInt);

		$sampleStruct->typeInt = 0b11111111; // 2進数
		$this->assertSame(0b11111111, $sampleStruct->typeInt);
	}

	/**
	 * @test
	 */
	public function testString()
	{
		$sampleStruct = new SampleStruct([
			'typeString' => 'string',
		]);
		$this->assertSame('string', $sampleStruct->typeString);

		$sampleStruct->typeString = 'Hello World.';
		$this->assertSame('Hello World.', $sampleStruct->typeString);

		$sampleStruct->typeString = '';
		$this->assertSame('', $sampleStruct->typeString);

		$sampleStruct->typeString = '1234';
		$this->assertSame('1234', $sampleStruct->typeString);
	}

	/**
	 * @test
	 */
	public function testBool()
	{
		$sampleStruct = new SampleStruct([
			'typeBool' => true,
		]);
		$this->assertSame(true, $sampleStruct->typeBool);

		$sampleStruct->typeBool = false;
		$this->assertSame(false, $sampleStruct->typeBool);
	}

	/**
	 * @test
	 */
	public function testFloat()
	{
		$sampleStruct = new SampleStruct([
			'typeFloat' => 0.12,
		]);
		$this->assertSame(0.12, $sampleStruct->typeFloat);

		$sampleStruct->typeFloat = 1.2345;
		$this->assertSame(1.2345, $sampleStruct->typeFloat);

		$sampleStruct->typeFloat = 6.88713E+009; // 指数形式
		$this->assertSame(6.88713E+009, $sampleStruct->typeFloat);
	}

	/**
	 * @test
	 */
	public function testArray()
	{
		$sampleStruct = new SampleStruct([
			'typeArray' => [1, 2, 3, 4, 5],
		]);
		$this->assertSame([1, 2, 3, 4, 5], $sampleStruct->typeArray);

		$sampleStruct->typeArray = [];
		$this->assertEmpty($sampleStruct->typeArray);

		$sampleStruct->typeArray = ['a' => 'apple', 'b' => 'banana'];
		$this->assertSame(['a' => 'apple', 'b' => 'banana'], $sampleStruct->typeArray);
	}

	/**
	 * @test
	 */
	public function testAny()
	{
		/**
		 * int
		 */

		// instantiate
		$sampleStruct = new SampleStruct([
			'typeAny' => 10,
		]);
		$this->assertSame(10, $sampleStruct->typeAny);

		// substitution
		$sampleStruct->typeAny = 1;
		$this->assertSame(1, $sampleStruct->typeAny);

		/**
		 * string
		 */

		// instantiate
		$sampleStruct = new SampleStruct([
			'typeAny' => 'string',
		]);
		$this->assertSame('string', $sampleStruct->typeAny);

		// substitution
		$sampleStruct->typeAny = 'Hello World.';
		$this->assertSame('Hello World.', $sampleStruct->typeAny);

		/**
		 * bool
		 */

		// instantiate
		$sampleStruct = new SampleStruct([
			'typeAny' => true,
		]);
		$this->assertTrue($sampleStruct->typeAny);

		// substitution
		$sampleStruct->typeAny = false;
		$this->assertFalse($sampleStruct->typeAny);

		/**
		 * float
		 */

		// instantiate
		$sampleStruct = new SampleStruct([
			'typeAny' => 0.12,
		]);
		$this->assertSame(0.12, $sampleStruct->typeAny);

		// substitution
		$sampleStruct->typeAny = 1.2345;
		$this->assertSame(1.2345, $sampleStruct->typeAny);

		/**
		 * array
		 */

		// instantiate
		$sampleStruct = new SampleStruct([
			'typeAny' => [1, 2, 3, 4, 5],
		]);
		$this->assertSame([1, 2, 3, 4, 5], $sampleStruct->typeAny);

		// substitution
		$sampleStruct->typeAny = [];
		$this->assertEmpty([], $sampleStruct->typeAny);

		/**
		 * object
		 */

		// instantiate
		$sampleStruct = new SampleStruct([
			'typeAny' => new \DateTime('2018-09-05 11:22:33'),
		]);
		$this->assertEquals('2018-09-05 11:22:33', $sampleStruct->typeAny->format('Y-m-d H:i:s'));

		// substitution
		$sampleStruct->typeAny = new \DateTime('2018-01-01 11:22:33');
		$this->assertEquals('2018-01-01 11:22:33', $sampleStruct->typeAny->format('Y-m-d H:i:s'));
	}

	/**
	 * @test
	 */
	public function testSetMethod()
	{
		$sampleStruct = new SampleMethodStruct([
			'typeInt' => 1,
		]);
		$this->assertSame(1, $sampleStruct->typeInt);

		$sampleStruct->setTypeInt(2);
		$this->assertSame(2, $sampleStruct->typeInt);
	}
}

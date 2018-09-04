<?php

namespace StructTest;

use PHPUnit\Framework\TestCase;
use Struct\Struct;

/**
 * Class CollectionTest
 * @package CollectionTest
 */
class StructTest extends TestCase
{

	// Structのテスト用インスタンス
	private $user;

	public function setUp()
	{
		$this->user = new User([
			'userId'      => 10,
			'accountName' => 'jon',
		]);
	}

	/**
	 * @test
	 */
	public function structTest()
	{
		$this->user->accountName = 'bob';
		$this->assertEquals('bob', $this->user->accountName);

		// $this->user->accountName = 12345;   // #=> Uncaught Exception: Trying to set a different type.
		$this->user->accountName = '12345';
		$this->assertEquals($this->user->accountName, '12345');

		// Anyプロパティは今までのpropertyと同じでなんでも入れられる
		$this->user->free = 'john';
		$this->assertEquals('john', $this->user->free);

		$this->user->free = 12345;
		$this->assertEquals('12345', $this->user->free);
	}
}

class User extends Struct
{
	protected $userId      = Struct::TYPE_INT;    // This is int.
	protected $accountName = Struct::TYPE_STRING; // This is string.
	protected $free        = Struct::TYPE_ANY;    // This is "any" type.
}


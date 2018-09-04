<?php

namespace Struct;

/**
 * [Struct]
 *
 * GolangやRustに近いstructのような型定義の実装を意識したクラス
 *
 * Usage:
 *
 * class User extends Struct
 * {
 *     protected $userId      = Struct::INT;    // This is int.
 *     protected $accountName = Struct::STRING; // This is string.
 *     protected $free        = Struct::ANY;    // This is "any" type.
 * }
 *
 * $user = New User([
 *     'userId'      => 10,
 *     'accountName' => 'jon',
 * ]);
 *
 * $user->accountName = 'bob';
 * echo $user->accountName; // #=> bob
 *
 * $user->accountName = 12345;   // #=> Uncaught Exception: Trying to set a different type.
 * $user->accountName = '12345';
 * echo $user->accountName; // #=> 12345
 *
 * // Anyプロパティは今までのpropertyと同じでなんでも入れられる
 * $user->free = 'colopl';
 * echo $user->free;
 * $user->free = 12345;
 * echo $user->free;
 *
 * // 初期値を決める場合はそのまま値を入れる
 * class User extends Struct
 * {
 *     protected $userId = 0;       // This is int.
 *     protected $accountName = ''; // This is string.
 *     protected $free;             // NULL is for "any" type.
 * }
 */
class Struct
{
	// Types
	const TYPE_INT    = 0;
	const TYPE_STRING = '';
	const TYPE_BOOL   = false;
	const TYPE_FLOAT  = 0.0;
	const TYPE_ARRAY  = [];
	const TYPE_ANY    = null;

	private $anyTypeProperties = [];

	/**
	 * @param array $args
	 */
	public function __construct(array $args)
	{
		foreach (get_object_vars($this) as $propertyName => $propertyValue) {
			if (is_null($propertyValue)) {
				$this->anyTypeProperties[] = $propertyName;
			}
		}

		foreach ($args as $propertyName => $propertyValue) {
			$this->setStrict($propertyName, $propertyValue);
		}
	}

	/**
	 * @param string $key
	 * @param mix $value
	 */
	public function __set($key, $value)
	{
		$this->setStrict($key, $value);
	}

	/**
	 * @param string $key
	 */
	public function __get($key)
	{
		return $this->{$key};
	}

	/**
	 * キーの存在と型のチェックを考慮したProperty更新
	 * Property update considering the existence of keys and type check.
	 *
	 * @param string $key
	 * @param mix $key
	 */
	private function setStrict($key, $value)
	{
		if (!property_exists($this, $key)) {
			throw new \Exception('Property "' . $key . '" does not exist on type ' . get_class($this) . '.');
		}

		if (!in_array($key, $this->anyTypeProperties) &&
			gettype($this->{$key}) !== gettype($value)
		) {
			throw new \Exception('Trying to set a different type. Property "' . $key . '" is [' . gettype($this->{$key}) . '] type.');
		}

		$this->{$key} = $value;
	}

	/**
	 * Structをもとに配列を返却
	 * Struct to array
	 * @return array
	 */
	public function toArray()
	{
		$array = [];

		foreach (get_object_vars($this) as $propertyName => $propertyValue) {
			if ($propertyName != 'anyTypeProperties') {
				$array[$propertyName] = $propertyValue;
			}
		}

		return $array;
	}
}

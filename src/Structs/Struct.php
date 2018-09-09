<?php

namespace Struct;

/**
 * [Struct]
 *
 * GolangやRustに近いstructのような型定義の実装を意識したクラス
 *
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
	private $protectedProperties = [];

	/**
	 * @param array $args
	 */
	public function __construct(array $args = [])
	{
		foreach (get_object_vars($this) as $propertyName => $propertyValue) {
			if (in_array($propertyName, ['protectedProperties', 'anyTypeProperties'])) {
				continue;
			}

			if (is_null($propertyValue)) {
				$this->anyTypeProperties[] = $propertyName;
			}

			$this->protectedProperties[$propertyName] = $propertyValue;
			unset($this->{$propertyName});
		}

		foreach ($args as $propertyName => $propertyValue) {
			// Calling __set() method
			$this->{$propertyName} = $propertyValue;
		}
	}

	/**
	 * @param string $key
	 * @param mix $value
	 */
	public function __set($key, $value)
	{
		$this->set($key, $value);
	}

	/**
	 * @param string $key
	 */
	public function __get($key)
	{
		return $this->protectedProperties[$key];
	}

	/**
	 * キーの存在と型のチェックを考慮したProperty更新
	 * Property update considering the existence of keys and type check.
	 *
	 * @param string $key
	 * @param mix $key
	 */
	protected function set($key, $value)
	{
		if (!property_exists($this, $key)) {
			throw new \Exception('Property "' . $key . '" does not exist on type ' . get_class($this) . '.');
		}

		if (!in_array($key, $this->anyTypeProperties) &&
			gettype($this->{$key}) !== gettype($value)
		) {
			throw new \Exception('Trying to set a different type. Property "' . $key . '" is [' . gettype($this->{$key}) . '] type.');
		}

		$this->protectedProperties[$key] = $value;
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

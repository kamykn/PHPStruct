<?php

namespace StructTest;

error_reporting(E_ALL | E_STRICT);
require __DIR__ . '/vendor/autoload.php';

use Struct\Struct;

class ExampleStruct extends Struct
{
	public $typeAny = Struct::TYPE_ANY;
	$typeInt = Struct::TYPE_INT;

	public function setTypeInt($int)
	{
		$this->set('typeInt', $int);
	}

	public function setTypeIntDirectory($int)
	{
		// __getで拾うので想定通りセットされる
		$this->typeInt = $int;
	}

	public function setTypeAnyDirectory($val)
	{
		// __getで拾うので想定通りセットされる
		$this->typeAny = $val;
	}
}

$ex = new ExampleStruct();

print_r($ex);

echo $ex->typeInt;

echo $ex->setTypeInt(5);
echo $ex->typeInt;

echo $ex->setTypeIntDirectory(10);
echo $ex->typeInt;

echo $ex->setTypeAnyDirectory('test');
echo $ex->typeAny;


print_r($ex);

echo $ex->setTypeIntDirectory('hello');
echo $ex->typeInt;

print_r($ex);

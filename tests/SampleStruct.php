<?php

namespace StructTest;

use Struct\Struct;

class SampleStruct extends Struct
{
	public $typeInt = Struct::TYPE_INT;
	public $typeString = Struct::TYPE_STRING;
	public $typeBool = Struct::TYPE_BOOL;
	public $typeFloat = Struct::TYPE_FLOAT;
	public $typeArray = Struct::TYPE_ARRAY;
	public $typeAny = Struct::TYPE_ANY;
}

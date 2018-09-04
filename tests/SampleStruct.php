<?php

namespace StructTest;

use Struct\Struct;

class SampleStruct extends Struct
{
	protected $typeInt    = Struct::TYPE_INT;
	protected $typeString = Struct::TYPE_STRING;
	protected $typeBool   = Struct::TYPE_BOOL;
	protected $typeFloat  = Struct::TYPE_FLOAT;
	protected $typeArray  = Struct::TYPE_ARRAY;
	protected $typeAny    = Struct::TYPE_ANY;
}

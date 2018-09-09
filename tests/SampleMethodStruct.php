<?php

namespace StructTest;

use Struct\Struct;

class SampleMethodStruct extends Struct
{
	public $typeInt = Struct::TYPE_INT;

	public function setTypeInt($int)
	{
		$this->typeInt = $int;
	}
}

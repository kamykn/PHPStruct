<?php

namespace StructTest;

use Struct\Struct;

class SampleMethodStruct extends Struct
{
	protected $typeInt = Struct::TYPE_INT;

	public function setTypeInt($int)
	{
		$this->set('typeInt', $int);
	}
}

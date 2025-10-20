<?php

namespace PrinceJohn\Weave;

use PrinceJohn\Weave\Exceptions\NoneToStringConversionException;

final class None
{
    public function __toString(): never
    {
        throw new NoneToStringConversionException;
    }
}

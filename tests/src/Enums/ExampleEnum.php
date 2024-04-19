<?php

namespace SaKanjo\EasyEnum\Tests\Enums;

use SaKanjo\EasyEnum;

enum ExampleEnum: int
{
    use EasyEnum;

    case USD = 0;
    case EURO = 1;
    case NOPE = 2;
}

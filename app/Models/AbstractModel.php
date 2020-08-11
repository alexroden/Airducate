<?php

namespace App\Models;

use AltThree\Validator\ValidatingTrait;
use App\Models\Concerns\DateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

class AbstractModel extends Model
{
    use DateTimeFormatter;
    use ValidatingTrait;
}

<?php

namespace App\Console\Commands;

use App\Traits\CommonTrait;
use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{
    use CommonTrait;
}

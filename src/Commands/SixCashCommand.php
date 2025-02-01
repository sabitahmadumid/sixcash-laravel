<?php

namespace SabitAhmad\SixCash\Commands;

use Illuminate\Console\Command;

class SixCashCommand extends Command
{
    public $signature = 'sixcash-laravel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}

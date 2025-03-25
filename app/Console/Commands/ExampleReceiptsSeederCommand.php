<?php

namespace App\Console\Commands;

use Database\Seeders\ExampleReceiptsSeeder;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class ExampleReceiptsSeederCommand extends Command implements PromptsForMissingInput
{
    protected $signature = 'receipts:seed {user_id}';

    protected $description = 'Seed example receipts';

    public function handle(ExampleReceiptsSeeder $seeder): void
    {
        $user_id = $this->argument('user_id');
        $seeder->run($user_id);
    }
}

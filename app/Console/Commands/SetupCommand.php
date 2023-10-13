<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compass:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command initializes the application.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::create([
            'name' => config('compass.admin.username'),
            'username' => config('compass.admin.username'),
            'email' => config('compass.admin.email'),
            'password' => bcrypt(config('compass.admin.password')),
            'is_admin' => true,
        ]);
    }
}

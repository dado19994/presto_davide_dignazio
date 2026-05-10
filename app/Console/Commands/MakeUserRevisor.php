<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeUserRevisor extends Command
{
    protected $signature = 'app:make-user-revisor {email}';

    protected $description = 'Rende un utente revisore';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        $user = User::query()->where('email', $email)->first();

        if (!$user) {
            $this->error('Utente non trovato.');

            return self::FAILURE;
        }

        $user->is_revisor = true;
        $user->save();

        $this->info("L'utente {$user->email} ora e' revisore.");

        return self::SUCCESS;
    }
}

<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MakeUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-user-admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a user admin based on their e-mail address';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $user = User::where('email', $this->argument('email'))->firstOrFail();
            $user->role = 'admin';
            $user->save();
        } catch(ModelNotFoundException $modelNotFoundException) {
            $this->error('The user was not found.');
            return;
        }


        $this->comment(sprintf('%s (%s) was made an admin', $user->name, $user->email));
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command creates a new admin user.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fields = ['fullname', 'email', 'password'];
        $done = false;
        $i = 0;

        while(!$done) {
            $info[$fields[$i]] = $this->ask('Enter '.$fields[$i]);

            if(!$info[$fields[$i]])
            {
                $this->error($fields[$i].' is required!');
            }

            if($fields[$i] === 'email'){
                $validator = Validator::make(['email' => $info['email']], ['email' => 'required|email|unique:admins,email']);

                if($validator->fails()){
                    $errors = $validator->errors();
                    $this->error($errors->first('email'));
                }
                else{
                    $i++;
                }
            }
            else{
                $i++;
            }

            ($i === count($fields)) && ($done = true);
        }

        Admin::create($info);

        $this->info('Admin has been created!');
    }
}

<?php

namespace App\Authentication;

use App\Models\User;

class Authentication
{
    public function user()
    {
        return User::find($_SESSION['user']);
    }

    public function check()
    {
        return isset($_SESSION['user']);
    }


    public function attempt(String $email, String $password)
    {
        //Gets user email
        $user = User::where('email', $email)->first();

        //If cannot find a user return false
        if(!$user) {
            return false;
        }

        if(password_verify($password, $user->password)) {
            $_SESSION['user'] = $user->id;
            return true;
        }
    }

    public function logout()
    {
        unset($_SESSION['user']);
    }
}

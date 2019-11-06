<?php

namespace App\Authentication;

use App\Models\User;

class Authentication
{
    /**
     * The user method returns a Model of type user
     * @return User Returns a Model of type User
     */
    public function user()
    {
        return User::find($_SESSION['user']);
    }

    /**
     * Checks if a user is logged in
     * @return bool Returns true if user is logged in
     */
    public function check()
    {
        return isset($_SESSION['user']);
    }

    /**
     * Makes an attempt to find a User using an email address
     * @param  String $email    Input string for email
     * @param  String $password Input string for email
     * @return bool             Returns true if successful
     */
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

    /**
     * Logs out current user in session
     * @return [type] [description]
     */
    public function logout()
    {
        unset($_SESSION['user']);
    }
}

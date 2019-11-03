<?php
namespace App\Validation\Rules;

use App\Models\User;
use Respect\Validation\Rules\AbstractRule;

class EmailAvailable extends AbstractRule
{
    public function validate($input)
    {
        //Queries the database, if the number of entries retrieved for
        //entered email is 0, validation has succeeded.
        return User::where('email', $input)->count() === 0;
    }

}

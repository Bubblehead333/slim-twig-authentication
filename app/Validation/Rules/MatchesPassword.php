<?php
namespace App\Validation\Rules;

use App\Models\User;
use Respect\Validation\Rules\AbstractRule;

/**
 * This validation Rule checks to see whether the User inputted password matches
 * that of the password stored on the database.
 */
class MatchesPassword extends AbstractRule
{
    protected $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    /**
     * This method validates the inputted string, with the password string
     * stored in the database.
     * @param  String $input [description]
     * @return bool        Validation check on passwords
     */
    public function validate($input)
    {
        return password_verify($input, $this->password);
    }

}

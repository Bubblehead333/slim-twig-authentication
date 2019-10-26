<?php

namespace App\Validation;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;


class Validator
{
    protected $errors;

    public function validate($request, array $rules)
    {
        foreach($rules as $field => $rule) {
            try{
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            }
            catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();
            }
        }

        //Attach errors to global session variables so they can be displayed on
        //a view
        $_SESSION['errors'] = $this->errors;

        //Validation Succeeded!
        return $this;
    }

    //This method is a simple check to see whether errors array is not empty
    public function failed()
    {
        return !empty($this->errors);
    }
}

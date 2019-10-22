<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //Eloquent attempts to automatically link this Model with a table of the
    //same name or a pluralised version. If this differs, you can explictly
    //declare the table to which the Model refers wih the following:
    protected $table = 'users';
}

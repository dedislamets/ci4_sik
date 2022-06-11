<?php

namespace App\Models;

use CodeIgniter\Model;

class Contact extends Model
{
    protected $table                = 'contacts';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $allowedFields        = ['name','email','phone','address'];
}

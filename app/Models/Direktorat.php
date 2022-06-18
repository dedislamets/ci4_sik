<?php

namespace App\Models;

use CodeIgniter\Model;

class Direktorat extends Model
{
    protected $table                = 'direktorat';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $allowedFields        = ['nama_direktorat'];


}

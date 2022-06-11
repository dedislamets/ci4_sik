<?php

namespace App\Models;

use CodeIgniter\Model;

class Karyawan extends Model
{
    protected $table                = 'karyawan';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $allowedFields        = ['nik','name','email','phone','address','status','agama','deputi'];

    public function getAll()
    {
         return $this->db->table('karyawan')
         ->join('deputi','deputi.id_deputi=karyawan.deputi')
         ->get()->getResultArray();  
    }
}

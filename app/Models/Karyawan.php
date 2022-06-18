<?php

namespace App\Models;

use CodeIgniter\Model;

class Karyawan extends Model
{
    protected $table                = 'karyawan';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $allowedFields        = ['nik','name','email','phone','address','status','agama','id_unit'];

    public function getAll()
    {
         return $this->db->table('karyawan')
         ->join('unit','unit.id=karyawan.id_unit')
         ->get()->getResultArray();  
    }
}

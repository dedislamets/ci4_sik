<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class Extention extends Model
{
    protected $table                = 'extention';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $allowedFields        = ['keterangan','id_unit','extention'];

    public function modal($id)
    {
         return $this->db->table($this->table)
         ->select("extention.*,id_direktorat")
         ->join("unit","unit.id=extention.id_unit","LEFT")
         ->where("extention.id",$id)
         ->get()->getRowArray(); 
    }
    
}

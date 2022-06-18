<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class DeputiDatatable extends Model
{
    protected $table = 'extention';
    protected $column_order = ['nama_direktorat','extention.id', 'nama_unit', 'keterangan','extention'];
    protected $column_search = ['nama_direktorat','nama_unit', 'keterangan','extention'];
    protected $order = ['extention.id' => 'DESC'];
    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table)
                ->select('extention.*,nama_unit,nama_direktorat')
                ->join("unit","unit.id=extention.id_unit")
                ->join("direktorat","unit.id_direktorat=direktorat.id");


    }

    private function getDatatablesQuery()
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function getDatatables()
    {
        $this->getDatatablesQuery();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function countFiltered()
    {
        $this->getDatatablesQuery();
        $this->dt->join("unit","unit.id=extention.id_unit")
                ->join("direktorat","unit.id_direktorat=direktorat.id");
        // echo $this->dt->getCompiledSelect(); exit();
        return $this->dt->countAllResults();
    }

    public function countAll()
    {
        $tbl_storage = $this->db->table($this->table)
                ->join("unit","unit.id=extention.id_unit")
                ->join("direktorat","unit.id_direktorat=direktorat.id");
        // $tbl_storage->join("deputi","deputi.id_deputi=karyawan.deputi");
        return $tbl_storage->countAllResults();
    }

}
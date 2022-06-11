<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class UserDatatable extends Model
{
    protected $table = 'karyawan';
    protected $column_order = ['id', 'name', 'email','phone','agama','status','nama_deputi'];
    protected $column_search = ['name', 'email','phone','agama','status','nama_deputi'];
    protected $order = ['id' => 'DESC'];
    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table);
        $this->dt->join("deputi","deputi.id_deputi=karyawan.deputi");

        $arr_where = array();

        if(!empty($request->getGet())){
        	$search = "filter_";
			$i = 0;
			foreach($request->getGet() as $key=> $value){
			    if(strstr($key,$search)){
			    	$counter = explode("_", $key);
			    	$arr_where[ $request->getGet($key) ] = $request->getGet("input_". $counter[1]);
        			// print("<pre>".print_r($arr_where,true)."</pre>");exit();
        			
        			if($i==0)	$this->dt->like( $request->getGet($key), $request->getGet("input_". $counter[1]) );
        			if($i>0)	$this->dt->like( $request->getGet($key), $request->getGet("input_". $counter[1]) );

        			$i++;
			    }
			}
        }

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
        return $this->dt->countAllResults();
    }

    public function countAll()
    {
        $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }

}
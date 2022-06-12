<?php

namespace App\Controllers;
use App\Models\Karyawan;
use App\Models\Deputi;
use Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;
use App\Models\UserDatatable;
use App\Models\DatatableKaryawan;
use Config\Services;

class Home extends BaseController
{
	function __construct()
    {

        $this->config = config('Auth');
        $this->auth   = service('authentication');
        
    }
    public function index()
    {
        return view('welcome_message');
    }
    public function dashboard()
    {
    	$this->karyawan = new Karyawan();
    	$this->deputi = new Deputi();
	    $data['karyawan'] = $this->karyawan->getAll();
	    $data['deputi'] = $this->deputi->findAll();
	    // print("<pre>".print_r($data,true)."</pre>");exit();
        return view('karyawan/index', $data);
    }

    public function create()
    {
        $this->karyawan = new Karyawan();
        $this->karyawan->insert([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'status' => $this->request->getPost('status'),
            'agama' => $this->request->getPost('agama'),
            'deputi' => $this->request->getPost('deputi'),
        ]);

		return redirect('dashboard')->with('success', 'Data Added Successfully');	
    }

    public function edit($id)
    {
        $this->karyawan = new Karyawan();
        $this->karyawan->update($id, [
                'name' => $this->request->getPost('name'),
	            'email' => $this->request->getPost('email'),
	            'phone' => $this->request->getPost('phone'),
	            'address' => $this->request->getPost('address'),
	            'status' => $this->request->getPost('status'),
	            'agama' => $this->request->getPost('agama'),
	            'deputi' => $this->request->getPost('deputi'),
            ]);

        return redirect('dashboard')->with('success', 'Data Updated Successfully');
    }
    public function listdata()
    {
 
        $request = Services::request();
        $list_data = new DatatableKaryawan($request);
        $where = ['id !=' => 0];
                //Column Order Harus Sesuai Urutan Kolom Pada Header Tabel di bagian View
                //Awali nama kolom tabel dengan nama tabel->tanda titik->nama kolom seperti pengguna.nama
        $column_order = array('id', 'name', 'email','phone','agama','status','nama_deputi');
        $column_search = array('name', 'email','phone','agama','status','nama_deputi');
        $order = array('id' => 'asc');
        $list = $list_data->get_datatables('karyawan', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->getPost("start");
        foreach ($list as $lists) {
            $no++;
            $row    = array();
            $row[] = $no;
            $row[] = $lists->name;
            $row[] = $lists->email;
            $row[] = $lists->phone;
            $row[] = $lists->agama;
            $row[] = $lists->status;
            $row[] = $lists->nama_deputi;
            if(!empty(user())){ 
                $row[] = '<button type="button" class="btn btn-primary btn-edit" data-id="'. $lists->id .'" onclick="showModal(this)">Edit</button>
                      <a href="'.base_url('dashboard/delete/'.$lists->id) .'" class="btn btn-danger" onclick="return confirm("Are you sure ?")">Delete</a>';
            }else{
                $row[] = '<button type="button" class="btn btn-warning btn-lihat" data-view="1" data-id="'. $lists->id .'" onclick="showModal(this)">Lihat</button>';
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => $request->getPost("draw"),
            "recordsTotal" => $list_data->count_all('karyawan', $where),
            "recordsFiltered" => $list_data->count_filtered('karyawan', $column_order, $column_search, $order, $where),
            "data" => $data,
        );
 
        return json_encode($output);
    }
    public function ajaxList()
    {
        $request = Services::request();
        $datatable = new UserDatatable($request);
        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            echo $lists->getCompiledSelect();exit();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->name;
                $row[] = $list->email;
                $row[] = $list->phone;
                $row[] = $list->agama;
                $row[] = $list->status;
                $row[] = $list->nama_deputi;
                if(!empty(user())){ 
                	$row[] = '<button type="button" class="btn btn-primary btn-edit" data-id="'. $list->id .'" onclick="showModal(this)">Edit</button>
                          <a href="'.base_url('dashboard/delete/'.$list->id) .'" class="btn btn-danger" onclick="return confirm("Are you sure ?")">Delete</a>';
              	}else{
              		$row[] = '<button type="button" class="btn btn-warning btn-lihat" data-view="1" data-id="'. $list->id .'" onclick="showModal(this)">Lihat</button>';
              	}
                
                $data[] = $row;
            }

            $output = [
                'draw' => $request->getPost('draw'),
                'recordsTotal' => $datatable->countAll(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function getKaryawan()
    {
        $this->karyawan = new Karyawan();
        $id = $this->request->getGet('id');
        $response = $this->karyawan->find($id);

        echo json_encode($response);
    }

    public function delete($id)
	{
        $this->karyawan = new Karyawan();
    	$this->karyawan->delete($id);

    	return redirect('dashboard')->with('success', 'Data Deleted Successfully');
	}
}

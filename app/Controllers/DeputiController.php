<?php

namespace App\Controllers;
use App\Models\Direktorat;
use Config\Services;
use App\Models\DeputiDatatable;

class DeputiController extends BaseController
{
    protected $direktorat;
 
    function __construct()
    {
        // $this->session = service('session');

        // $this->config = config('Auth');
        // $this->auth   = service('authentication');

        // if ($this->auth->check()) 
        // {
        //     session()->set('redirect_url', current_url());
        //     return redirect('login');
        // }
        
    }

    public function index()
    {        
        $this->direktorat = new Direktorat();
	    $data['deputis'] = $this->direktorat->findAll();

        return view('deputi/index', $data);
    }

    public function create()
    {
        $this->deputi = new Direktorat();
        $this->deputi->insert([
            'nama_direktorat' => $this->request->getPost('nama_direktorat')
        ]);

		return redirect('deputi')->with('success', 'Data Added Successfully');	
    }
    public function edit($id)
    {
        $this->deputi = new Direktorat();
        $this->deputi->update($id, [
                'nama_direktorat' => $this->request->getPost('nama_direktorat')
            ]);

            return redirect('deputi')->with('success', 'Data Updated Successfully');
    }

    public function delete($id)
	{
        $this->deputi = new Direktorat();
    	$this->deputi->delete($id);

    	return redirect('deputi')->with('success', 'Data Deleted Successfully');
	}

    public function getDeputi()
    {
        $this->deputi = new Direktorat();
        $id = $this->request->getGet('id');
        $response = $this->deputi->find($id);

        echo json_encode($response);
    }

    public function ajaxList()
    {
        $request = Services::request();
        $datatable = new DeputiDatatable($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->nama_deputi;
                $row[] = $list->keterangan;
                $row[] = $list->extention;
                if(!empty(user())){ 
                    $row[] = '<button type="button" class="btn btn-primary btn-edit" data-id="'. $list->id_deputi .'" onclick="showModal(this)">Edit</button>
                          <a href="'.base_url('deputi/delete/'.$list->id_deputi) .'" class="btn btn-danger" onclick="return confirm("Are you sure ?")">Delete</a>';
                }else{
                    $row[] = '<button type="button" class="btn btn-warning btn-lihat" data-view="1" data-id="'. $list->id_deputi .'" onclick="showModal(this)">Lihat</button>';
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
    

}
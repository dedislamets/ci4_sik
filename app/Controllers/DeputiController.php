<?php

namespace App\Controllers;
use App\Models\Deputi;

class DeputiController extends BaseController
{
    protected $deputi;
 
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
        $this->deputi = new Deputi();
	    $data['deputis'] = $this->deputi->getAll();
        $data['text'] = $this->deputi->getAllText();

        return view('deputi/index', $data);
    }

    public function create()
    {
        $this->deputi = new Deputi();
        $this->deputi->insert([
            'nama_deputi' => $this->request->getPost('nama_deputi'),
            'extention' => $this->request->getPost('extention'),
            'parent_id' => $this->request->getPost('parent_id')
        ]);

		return redirect('deputi')->with('success', 'Data Added Successfully');	
    }
    public function edit($id)
    {
        $this->deputi = new Deputi();
        $this->deputi->update($id, [
                'nama_deputi' => $this->request->getPost('nama_deputi'),
                'extention' => $this->request->getPost('extention'),
                'parent_id' => $this->request->getPost('parent_id')
            ]);

            return redirect('deputi')->with('success', 'Data Updated Successfully');
    }

    public function delete($id)
	{
        $this->deputi = new Deputi();
    	$this->deputi->delete($id);

    	return redirect('deputi')->with('success', 'Data Deleted Successfully');
	}

    public function getDeputi()
    {
        $this->deputi = new Deputi();
        $id = $this->request->getGet('id');
        $response = $this->deputi->find($id);

        echo json_encode($response);
    }
    

}
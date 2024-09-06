<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dgi_api_key_group extends CI_Controller
{

  var $folder = "master";
  var $page   = "dgi_api_key_group";
  var $title  = "Key Management Dealer Group Integration Group";
  protected $key;


  public function __construct()
	{		
		parent::__construct();
		
		//===== Load Database =====
		$this->load->database();
		$this->load->helper('url');
		//===== Load Model =====
		$this->load->model('m_admin');		
		$this->load->model('m_dgi_api_group');		
		//===== Load Library =====
		$this->load->library('upload');
		
		$name = $this->session->userdata('nama');
		$auth = $this->m_admin->user_auth($this->page,"select");		
		$sess = $this->m_admin->sess_auth();						
		if($name=="" OR $auth=='false')
		{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."denied'>";
		}elseif($sess=='false'){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."crash'>";
		}

	}
	protected function template($data)
	{
		$name = $this->session->userdata('nama');
		if($name=="")
		{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."panel'>";
		}else{						
			$data['id_menu'] = $this->m_admin->getMenu($this->page);
			$data['group'] 	= $this->session->userdata("group");
			$this->load->view('template/header',$data);
			$this->load->view('template/aside');			
			$this->load->view($this->folder."/".$this->page);		
			$this->load->view('template/footer');
		}
	}

  public function index()
  {
    $data['isi']       = $this->page;
    $data['title']     = $this->title;
    $data['set']       = "view";
    $this->template($data);
  }

  public function jsonApiGroup() {
    $startDate = $this->input->post('startDate');
    $endDate = $this->input->post('endDate');
    $status = $this->input->post('status');
    $dataAPI = $this->m_dgi_api_group->getGetApiKeyGroup($startDate, $endDate, $status);
    $data = array();

    $uniqueGroups = array();

    foreach ($dataAPI as $apiGroup) {
        if (!in_array($apiGroup->dealer_group, $uniqueGroups)) {
            $uniqueGroups[] = $apiGroup->dealer_group;

            $row = array();
            // $row['id_dealer_int'] = $apiGroup->id_dealer_int;
            $row['dealer_group'] = $apiGroup->dealer_group;
            $row['api_key_group'] = $apiGroup->api_key_group;
            $row['secret_key_group'] = $apiGroup->secret_key_group;

            $data[] = $row;
        }
    }

    $result = array(
        'draw' => @$_POST['draw'],
        'recordsTotal' => $this->m_dgi_api_group->countAllApiGroup(),
        'recordsFiltered' => $this->m_dgi_api_group->countFilterApiGroup($startDate, $endDate, $status),
        'data' => $data,
    );

    echo json_encode($result);
}

public function detail($dealer_group) {
    $data['detail'] = $this->m_dgi_api_group->getDetailsByDealerGroup($dealer_group);
    $data['isi']    = $this->page;		
    $data['title']	= $this->title;		
    $data['set']	= "detail";								
    $this->template($data);
}


  function generateKey()
  {
    $post = $this->input->post();
    $result = $this->m_dgi->generate_key($post);
    if ($result) {
      $response = ['status' => 'sukses', 'data' => $result];
    } else {
      $response = ['status' => 'gagal', 'pesan' => 'Generate API Key & Secret Key gagal. Silahkan coba lagi'];
    }
    send_json($response);
  }

  public function add()
  {				
      $data['isi']    = $this->page;		
      $data['title']	= $this->title;		
      $data['set']	= "insert";								
      $this->template($data);	
  }

//   public function add()
//   {
//     $data['isi']    = $this->page;
//     $data['title']  = $this->title;
//     $data['set']    = "form";
//     $data['mode']    = "insert";
//     $this->template($data);
//   }

  public function setting()
  {
    $data['isi']    = $this->page;
    $data['title']  = $this->title;
    $data['set']    = "form_setting";
    $data['mode']    = "setting";
    $this->template($data);
  }

  public function saveDealerGroupDetail()
    {
        $waktu = gmdate("Y-m-d H:i:s", time() + 60 * 60 * 7);
        $login_id = $this->session->userdata('id_user');
        $post = $this->input->post();

        $this->db->trans_begin();

        foreach ($post['dealers'] as $dealer) {
            $data = [
                'id_dealer' => $dealer['id_dealer'],
                'dealer_group' => $post['dealer_group'],
                'api_key_group' => $post['api_key_group'],
                'secret_key_group' => $post['secret_key_group'],
                'active' => $post['active'],
                'created_at' => $waktu,
                'created_by' => $login_id
            ];

            $this->db->insert('ms_dgi_api_key_group', $data);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $rsp = [
                'status' => 'error',
                'pesan' => 'Something went wrong'
            ];
        } else {
            $this->db->trans_commit();
            $rsp = [
                'status' => 'sukses',
                'link' => base_url('master/dgi_api_key_group')
            ];
            $_SESSION['pesan'] = "Data has been saved successfully";
            $_SESSION['tipe'] = "success";
        }

        echo json_encode($rsp);
        return redirect('master/dgi_api_key_group');
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProsesController extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    
	public function hapus($id){
		$_id = $this->db->get_where('tb_convert',['id' => $id])->row();

		$query = $this->db->delete('tb_convert', ['id' => $id]);
		if($query){
			unlink(FCPATH . 'assets/img/original/'.$_id->original);
			unlink(FCPATH . 'assets/img/webp/'.$_id->webp);
		}

		redirect(base_url(''));
	}
}
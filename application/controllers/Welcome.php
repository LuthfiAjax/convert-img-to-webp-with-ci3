<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

	public function index()
	{
		$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
		
		if ($this->form_validation->run() == false){
			$data['convert'] = $this->db->get('tb_convert')->result_array();

			$this->load->view('templates/header', $data);
			$this->load->view('Home');
			$this->load->view('templates/footer');
			$this->load->view('templates/modal');
		}else{
			$nama = $this->input->post('nama');
			$gambar = $_FILES['gambar'];

			if ($gambar=''){
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gambar Tidak Boleh Kosong</div>');
				redirect(base_url(''));
			}else{
				$config['allowed_types'] = 'gif|jpg|jpeg|png|heif|hevc';
				$config['max_size']      = '15360';
				$config['upload_path'] = './assets/img/original/';

				$this->load->library('upload', $config);

				if(!$this->upload->do_upload('gambar')){
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Patikan Format Gambar Benar</div>');
					redirect(base_url(''));
				}else{
					$gambar=$this->upload->data('file_name');
				}
			}

			$data = array (
				'nama' => $nama,
				'original' => $gambar
			);
			$this->db->insert('tb_convert', $data);
			$this->_convert($gambar);

		}
	}

	private function _convert($gambar){
		$_gambar = $this->db->get_where('tb_convert',['original' => $gambar])->row();

		$namaFile = $_gambar->original;
		$nama = substr($_gambar->original, 0, -4);
		$ekstensi = substr($_gambar->original, -3);

		// Image
		$dir = 'assets/img/original/';
		$webp = 'assets/img/webp/';
		$name = $namaFile;
		$newName = $nama.'.webp';

		switch ($ekstensi) {
			case "jpg":
				// Create and save
				$img = imagecreatefromjpeg($dir . $name);
				imagepalettetotruecolor($img);
				imagealphablending($img, true);
				imagesavealpha($img, true);
				imagewebp($img, $webp . $newName, 100);
				imagedestroy($img);

				$data = array (
					'webp' => $newName
				);

				$this->db->set($data);
				$this->db->where('original', $gambar);
				$this->db->update('tb_convert');
				
				redirect(base_url(''));
				break;

			case "png":
				// Create and save
				$img = imagecreatefrompng($dir . $name);
				imagepalettetotruecolor($img);
				imagealphablending($img, true);
				imagesavealpha($img, true);
				imagewebp($img, $webp . $newName, 100);
				imagedestroy($img);

				$data = array (
					'webp' => $newName
				);

				$this->db->set($data);
				$this->db->where('original', $gambar);
				$this->db->update('tb_convert');
				
				redirect(base_url(''));
				break;

			case "gif":
			  	// Create and save
				$img = imagecreatefromgif($dir . $name);
				imagepalettetotruecolor($img);
				imagealphablending($img, true);
				imagesavealpha($img, true);
				imagewebp($img, $webp . $newName, 100);
				imagedestroy($img);

				$data = array (
					'webp' => $newName
				);

				$this->db->set($data);
				$this->db->where('original', $gambar);
				$this->db->update('tb_convert');
				
				redirect(base_url(''));
				break;

			default:
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Hanya JPG, PNG, and GIF</div>');
			  	base_url('');
		  }
	}

}
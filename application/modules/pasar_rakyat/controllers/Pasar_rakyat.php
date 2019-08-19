<?php defined("BASEPATH") or exit("No direct script access allowed");

/**
 * Pasar_rakyat Controller.
 */
class Pasar_rakyat extends MY_Controller
{
    private $title;

    public function __construct()
    {
        parent::__construct();

        $this->title = "Pasar";
    }

    /**
     * Index
     */
    public function index()
    {
		$crud = new grocery_CRUD();
		
		$crud->set_table("pasar_rakyat");
		$crud->set_subject("Pasar");

		// Show in
		$crud->add_fields(["nama", "alamat", "luas_lahan", "luas_bangunan", "jumlah_kios", "jumlah_los", "pengeloaan", "latitude", "longitude", "foto", "keterangan"]);
		$crud->edit_fields(["nama", "alamat", "luas_lahan", "luas_bangunan", "jumlah_kios", "jumlah_los", "pengeloaan", "latitude", "longitude", "foto", "keterangan"]);
		$crud->columns(["nama", "alamat", "luas_lahan", "luas_bangunan", "jumlah_kios", "jumlah_los", "pengeloaan", "latitude", "longitude", "foto", "keterangan"]);
		$crud->order_by('nama', 'desc');

		// Fields type
		$crud->field_type("id_pasar", "integer");
		$crud->field_type("nama", "string");
		$crud->unset_texteditor("alamat", 'full_text');
		$crud->field_type("alamat", "text");
		$crud->field_type("luas_lahan", "string");
		$crud->field_type("luas_bangunan", "string");
		$crud->field_type("jumlah_kios", "string");
		$crud->field_type("jumlah_los", "string");
		$crud->field_type("pengeloaan", "enum");
		$crud->field_type("latitude", "string");
		$crud->field_type("longitude", "string");
		$crud->set_field_upload("foto", 'assets/uploads');
		$crud->set_field_upload("foto2", 'assets/uploads');
		$crud->set_field_upload("foto3", 'assets/uploads');
		$crud->set_field_upload("foto4", 'assets/uploads');
		$crud->unset_texteditor("keterangan", 'full_text');
		$crud->field_type("keterangan", "text");
		// Relation n-n

		// Display As

		// Unset action

		if($this->uri->segment(3, 0) === 'read'){
			$template_data['grocery_css'] = $data['css_files'];
			$template_data['grocery_js']  = $data['js_files'];
			$template_data["title"] = "Pasar";
			// $template_data["crumb"] = ["Pasar" => "pasar",];
			$id = $this->uri->segment(4, 0);
			$data['l'] = $this->db->where('id_pasar', $id)->get('pasar_rakyat')->row();
			$this->load->view('pasar_rakyat/detail', $data);
		}else{
			$data = (array) $crud->render();

			$this->layout->set_wrapper( 'grocery', $data,'page', false);

			$template_data['grocery_css'] = $data['css_files'];
			$template_data['grocery_js']  = $data['js_files'];
			$template_data["title"] = "Pasar";
			$template_data["crumb"] = ["Pasar" => "pasar",];
			$this->layout->auth();
			$this->layout->render('admin', $template_data); // front - auth - admin
		}
    }

    /**
     * CRUD
     */
}

/* End of file example.php */
/* Location: ./application/modules/pasar_rakyat/controllers/Pasar_rakyat.php */
<?php defined("BASEPATH") or exit("No direct script access allowed");

/**
 * Toko_modern Controller.
 */
class Toko_modern extends MY_Controller
{
    private $title;

    public function __construct()
    {
        parent::__construct();

        $this->title = "Toko Modern";
    }

    /**
     * Index
     */
    public function index()
    {
		$crud = new grocery_CRUD();
		
		$crud->set_table("toko_modern");
		$crud->set_subject("Toko Modern");

		// Show in
		$crud->add_fields(["nama", "alamat", "kepemilikan", "izin", "latitude", "longitude", "foto", "keterangan"]);
		$crud->edit_fields(["nama", "alamat", "kepemilikan", "izin", "latitude", "longitude", "foto", "keterangan"]);
		$crud->columns(["nama", "alamat", "kepemilikan", "izin", "latitude", "longitude", "foto", "keterangan"]);
		$crud->order_by('nama', 'desc');

		// Fields type
		$crud->field_type("id_toko", "integer");
		$crud->field_type("nama", "string");
		$crud->unset_texteditor("alamat", 'full_text');
		$crud->field_type("alamat", "text");
		$crud->field_type("kepemilikan", "string");
		$crud->field_type("izin", "string");
		$crud->field_type("latitude", "string");
		$crud->field_type("longitude", "string");
		$crud->set_field_upload("foto", 'assets/uploads');
		$crud->unset_texteditor("keterangan", 'full_text');
		$crud->field_type("keterangan", "text");

		// Relation n-n

		// Display As

		// Unset action

		$data = (array) $crud->render();

		$this->layout->set_wrapper( 'grocery', $data,'page', false);

		$template_data['grocery_css'] = $data['css_files'];
		$template_data['grocery_js']  = $data['js_files'];
		$template_data["title"] = "Toko Modern";
		$template_data["crumb"] = ["Toko Modern" => "toko_modern",];
		//$this->layout->auth();
		$this->layout->render('admin', $template_data); // front - auth - admin
	
    }

    /**
     * CRUD
     */
}

/* End of file example.php */
/* Location: ./application/modules/toko_modern/controllers/Toko_modern.php */
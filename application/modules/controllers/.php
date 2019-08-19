<?php defined("BASEPATH") or exit("No direct script access allowed");

/**
 *  Controller.
 */
class  extends MY_Controller
{
    private $title;

    public function __construct()
    {
        parent::__construct();

        $this->title = "";
    }

    /**
     * Index
     */
    public function index()
    {
    }

    /**
     * CRUD
     */
	public function crud()
	{
		$crud = new grocery_CRUD();
		
		$crud->set_table("");
		$crud->set_subject("");

		// Show in
		$crud->add_fields([""]);
		$crud->edit_fields([""]);
		$crud->columns([""]);

		// Fields type

		// Relation n-n

		// Display As

		// Unset action

		$data = (array) $crud->render();

		$this->layout->set_wrapper( 'grocery', $data,'page', false);

		$template_data['grocery_css'] = $data['css_files'];
		$template_data['grocery_js']  = $data['js_files'];
		$template_data["title"] = "";
		$template_data["crumb"] = [];
		//$this->layout->auth();
		$this->layout->render('admin', $template_data); // front - auth - admin
	}
}

/* End of file example.php */
/* Location: ./application/modules//controllers/.php */
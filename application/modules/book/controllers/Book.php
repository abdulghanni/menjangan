<?php defined("BASEPATH") or exit("No direct script access allowed");

/**
 * Book Controller.
 */
class Book extends MY_Controller
{
    private $title;

    public function __construct()
    {
        parent::__construct();

        $this->title = "Book";
    }

    /**
     * Index
     */
    public function index()
    {
		$crud = new grocery_CRUD();
		
		$crud->set_table("book");
		$crud->set_subject("Book");

		// Show in
		$crud->add_fields(["id_book", "book_name", "rating", "content"]);
		$crud->edit_fields(["id_book", "book_name", "rating", "content"]);
		$crud->columns(["id_book", "book_name", "rating", "content"]);
		$crud->order_by('id_book', 'desc');

		// Fields type
		$crud->field_type("id_book", "string");
		$crud->field_type("book_name", "string");
		$crud->field_type("rating", "string");
		$crud->field_type("content", "string");

		// Relation n-n

		// Display As

		// Unset action

		$data = (array) $crud->render();

		$this->layout->set_wrapper( 'grocery', $data,'page', false);

		$template_data['grocery_css'] = $data['css_files'];
		$template_data['grocery_js']  = $data['js_files'];
		$template_data["title"] = "Book";
		$template_data["crumb"] = ["Book" => "",];
		//$this->layout->auth();
		$this->layout->render('admin', $template_data); // front - auth - admin
	
    }

    /**
     * CRUD
     */
}

/* End of file example.php */
/* Location: ./application/modules/book/controllers/Book.php */
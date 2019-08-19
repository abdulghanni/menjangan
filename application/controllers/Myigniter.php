<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Name : myIgniter base controller.
 *
 * @version 3.9.5
 *
 * @author : Kotaxdev
 */

require_once APPPATH.'libraries/traits/Social_login.php';
require_once APPPATH.'libraries/traits/DB_Manager.php';

class Myigniter extends MY_Controller
{
    use Social_login,DB_Manager;
    // Site
    private $title;
    private $logo;

    // Template
    private $admin_template;
    private $front_template;
    private $auth_template;

    // Auth view
    private $login_view;
    private $register_view;
    private $forgot_password_view;
    private $reset_password_view;

    // Default page
    private $default_page;
    private $login_success;

    // Lang
    private $langCode = [
        'english' => 'us',
        'french' => 'fr',
        'indonesian' => 'id',
        'italian' => 'it',
        'arabic' => 'eg',

    ];

    public function __construct()
    {
        parent::__construct();

        // Site
        $site = $this->config->item('site');
        $this->title = $site['title'];
        $this->logo = $site['logo'];

        // Template
        $template = $this->config->item('template');
        $this->admin_template = $template['backend_template'];
        $this->front_template = $template['front_template'];
        $this->auth_template = $template['auth_template'];

        // Auth view
        $view = $this->config->item('view');
        $this->login_view = $view['login'];
        $this->register_view = $view['register'];
        $this->forgot_password_view = $view['forgot_password'];
        $this->reset_password_view = $view['reset_password'];

        // Default page
        $route = $this->config->item('route');
        $this->default_page = $route['default_page'];
        $this->login_success = $route['login_success'];
    }

    /**
     * Default page.
     *
     * @return HTML
     **/
    public function index()
    {
     
                $this->page($this->default_page);
       
    }
    
    

    /**
     * Change language
     * @param  string $lang language
     * @return void
     */
    public function sys_lang($lang = '')
    {
        $dir = '.' . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'language';
        $languages = scandir($dir);
        unset($languages[0], $languages[1]);
        if (in_array($lang, $languages)) {
            $this->session->set_userdata('lang_code', $this->langCode[$lang]);
            $this->session->set_userdata('lang', $lang);
            redirect((last_url() == '') ? '' : last_url());
        } else {
            $this->page_404();
        }
    }

    /**
     * Main dashboard page.
     *
     * @return HTML
     **/
    public function dashboard()
    {
        last_url('set'); // save last url
        // models
        $this->load->model('users_model');

        // helpers
        $this->load->helper('utility_helper');

        // database date
        $data['database'] = $this->db->database;
        
        // users data
        $data['users'] = $this->users_model->get_newest(8);
        $data['total_users'] = count($data['users']);

        // layout view
        $this->layout->set_wrapper('dashboard', $data);

        $this->layout->auth();

        $template_data['title'] = 'Dashboard';
        $template_data['crumb'] = [
            'Dashboard' => '',
        ];

        $this->layout->setCacheAssets();

        $this->layout->render('admin', $template_data);
    }

    /**
     * Profile page.
     *
     * @return HTML
     **/
    public function profile()
    {
        last_url('set'); // save last url
        $this->layout->set_wrapper('profile');
        $this->layout->auth();

        $template_data['title'] = 'User Profile';
        $template_data['crumb'] = [
        'User Profile' => '',
        ];
        $this->layout->render('admin', $template_data);
    }

    /**
     * Register page.
     *
     * @return HTML
     **/
    public function register()
    {
        if ($this->ion_auth->logged_in()) {
            redirect('');
        }
        $this->load->model('logs');

        if ($this->input->post('email')) {
            $fullname = $this->input->post('fullname');
            $password = $this->input->post('password');
            $email = $this->input->post('email');
            if ($this->input->post('additional')) {
                $additional = json_encode($this->input->post('additional'));
            } else {
                $additional = '';
            }

            $fullnameEx = explode(' ', $fullname);
            $this->db->order_by('id', 'desc');
            $id_user = $this->db->get('users')->row()->id;
            $username = strtolower($fullnameEx[0]).'-'.$id_user;

            $additional_data = [
            'full_name' => $fullname,
            'additional' => $additional,
            ];

            $register = $this->ion_auth->register($username, $password, $email, $additional_data);

            if ($register) {
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $dataLog = [
                'status' => true,
                'via' => 'front',
                'identity' => $email,
                'ip' => $this->input->ip_address()
                ];
                $this->logs->addLogs('register', $dataLog);

                $this->login($email, $password);
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                $dataLog = [
                'status' => false,
                'via' => 'front',
                'message' => str_replace('&times;Close', '', strip_tags($this->ion_auth->errors())),
                'identity' => $email,
                'ip' => $this->input->ip_address()
                ];
                $this->logs->addLogs('register', $dataLog);

                redirect('register');
            }
        } else {
            $data['name'] = $this->title;
            $data['logo'] = $this->logo;
            $data['message'] = $this->session->flashdata('message');
            $data['features'] = $this->config->item('features');
            $data['google_recaptcha'] = $this->config->item('google_recaptcha');
            $this->layout->set_wrapper($this->register_view, $data);

            $template_data['js_plugins'] = [base_url('assets/js/myigniter/register.js')];
            if ($data['features']['google_recaptcha']) {
                $template_data['js_plugins'][] = '//www.google.com/recaptcha/api.js';
            } else {
                $this->layout->setCacheAssets();
            }

            $this->layout->render('auth', $template_data);
        }
    }

    /**
     * Login page.
     *
     * @return HTML
     **/
    public function login($identity = null, $password = null)
    {
        $data['features'] = $this->config->item('features');
        
        if ($this->ion_auth->logged_in()) {
            redirect(last_url());
        }

        $this->load->model('logs');
        
        if (!$data['features']['disable_all_social_logins']) {
            $this->social_login_init();

            $sociallogin = $this->social_login(); // Return Fb and google login urls array from main controller

            if ($data['features']['login_via_facebook']) {
                $data['login_url'] = $sociallogin[0]; // Login_url is used to get FB Login Url from main controller
            }
            if ($data['features']['login_via_google']) {
                  $data['googlelogin'] = $sociallogin[1]; // googlelogin is used to get Google Login Url from main controller
            }
            if ($data['features']['login_via_google']) {
                  $data['twitter'] = $sociallogin[2]; // twitterlogin is used to get twitter Login Url from main controller
            }
        }

        if ($this->input->post('identity') || $identity != null) {
            if ($identity == null) {
                $identity = $this->input->post('identity');
                $password = $this->input->post('password');
                $remember = (bool) $this->input->post('remember');
            } else {
                $remember = false;
            }

            if ($this->ion_auth->login($identity, $password, $remember)) {
                $dataLog = [
                    'status' => true,
                    'identity' => $identity,
                    'ip' => $this->input->ip_address()
                ];
                $this->logs->addLogs('login', $dataLog);

                redirect((last_url() == '') ? $this->login_success : last_url());
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                $dataLog = [
                    'status' => false,
                    'message' => str_replace('&times;Close', '', strip_tags($this->ion_auth->errors())),
                    'identity' => $identity,
                    'ip' => $this->input->ip_address()
                ];
                $this->logs->addLogs('login', $dataLog);

                redirect('login');
            }
        } else {
            $data['name'] = $this->title;
            $data['logo'] = $this->logo;
            $data['message'] = $this->session->flashdata('message');
            $data['google_recaptcha'] = $this->config->item('google_recaptcha');
            $this->layout->set_wrapper($this->login_view, $data);
            
            $template_data['js_plugins'] = [base_url('assets/js/myigniter/login.js')];
            if ($data['features']['google_recaptcha']) {
                $template_data['js_plugins'][] = '//www.google.com/recaptcha/api.js';
            } else {
                $this->layout->setCacheAssets();
            }

            $this->layout->render('auth', $template_data); // auth_template
        }
    }

    /*
     *  Link function is used to call login with linkedin function
     *  of My_Contoller
     */

    public function link()
    {
        $this->load->model('Signupmodel', 'signup');  // Load Model
        $data['data'] = array('lType' => 'initiate', 'linkedin' => 'Connect to LinkedIn New Login');    // Important array need to pass in linkedin library to trigger the linkedin api.
        $this->social_login_linkedin($data['data']);     // Call social_login_linkedin function and pass data to the function
    }

    /**
     * Activate.
     **/
    public function activate($id, $code = false)
    {
        if ($code !== false) {
            $activation = $this->ion_auth->activate($id, $code);
        } elseif ($this->ion_auth->is_admin()) {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation) {
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect('login');
        } else {
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect('forgot-password');
        }
    }

    /**
     * Forgot Password.
     **/
    public function forgot_password()
    {
        if ($this->input->post('identity')) {
            if ($this->config->item('identity', 'ion_auth') == 'username') {
                $this->db->where('username', $this->input->post('identity'));
                $object = ['forgotten_password_code' => null, 'forgotten_password_time' => null];
                $this->db->update('users', $object);
                $identity = $this->ion_auth->where('username', strtolower($this->input->post('identity')))->users()->row();
            } else {
                $this->db->where('email', $this->input->post('identity'));
                $object = ['forgotten_password_code' => null, 'forgotten_password_time' => null];
                $this->db->update('users', $object);
                $identity = $this->ion_auth->where('email', strtolower($this->input->post('identity')))->users()->row();
            }

            if (empty($identity)) {
                if ($this->config->item('identity', 'ion_auth') == 'username') {
                    $this->ion_auth->set_message('forgot_password_username_not_found');
                } else {
                    $this->ion_auth->set_message('forgot_password_email_not_found');
                }

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('forgot-password');
            }

            // Run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

            if ($forgotten) {
                // If there were no errors
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('login'); // we should display a confirmation page here instead of the login page
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('forgot-password');
            }
        } else {
            $data['name'] = $this->title;
            $data['logo'] = $this->logo;
            $data['message'] = $this->session->flashdata('message');
            $this->layout->set_wrapper($this->forgot_password_view, $data);

            $this->layout->setCacheAssets();

            $this->layout->render('auth');
        }
    }

    /**
     * Final Forgot Password.
     *
     * @return Redirect
     **/
    public function reset_password($code = null)
    {
        if (!$code) {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {
            if ($this->input->post('password')) {
                $identity = $user->{$this->config->item('identity', 'ion_auth')};
                $change = $this->ion_auth->reset_password($identity, $this->input->post('password'));

                if ($change) {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    $this->logout();
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    redirect('reset-password/'.$code);
                }
            } else {
                $data['name'] = $this->title;
                $data['logo'] = $this->logo;
                $data['code'] = $code;
                $data['user_id'] = $user->id;
                $data['message'] = $this->session->flashdata('message');
                $this->layout->set_wrapper($this->reset_password_view, $data);

                $this->layout->render('auth');
            }
        } else {
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect('forgot-password');
        }
    }

    /**
     * Logout.
     *
     * @return Redirect
     **/
    public function logout()
    {
        $this->load->model('logs');
        $this->load->helper('utility_helper');

        $user = $this->ion_auth->user()->row();
        $dataLog = [
            'status' => true,
            'id' => $user->id,
            'identity' => $user->email,
            'ip' => $this->input->ip_address()
        ];
        $this->logs->addLogs('logout', $dataLog);

        $logout = $this->ion_auth->logout();
        $this->session->unset_userdata([
            'identity',
            'username',
            'old_last_login',
            'last_url',
            'fb_978900922179232_code',
            'fb_978900922179232_access_token',
            'google_access_token',
            'token',
            'token_secret'
        ]);

        redirect('login');
    }

    /**
     * Page builder.
     *
     * @return HTML
     **/
    public function page_builder()
    {
        last_url('set'); // save last url
        $this->load->library('Grocery_CRUD');
        $crud = new grocery_CRUD();

        $crud->set_table('page');
        $crud->set_subject('Page');

        // Views Base myIgniter
        $dir = './application/views/page';
        $files = scandir($dir);
        $view_list['default'] = 'default';
        foreach ($files as $key => $value) {
            if ($key != 0 && $key != 1) {
                if (strpos($value, '.php')) {
                    $view_page = str_replace('.php', '', $value);
                    $view_list[$view_page] = $view_page;
                }
            }
        }

        $crud->field_type('view', 'dropdown', $view_list);
        $crud->callback_field('breadcrumb', array($this, 'breadcrumb_callback'));
        $crud->callback_field('template', array($this, 'template_page'));
        $crud->callback_before_insert(array($this, 'slug_page_check'));
        $crud->callback_before_update(array($this, 'slug_page_check'));
        $crud->callback_column('slug', array($this, 'slug_page_link'));
        $crud->callback_column('Generate Module', array($this, 'export_php_callback'));
        $crud->set_field_upload('featured_image', 'assets/uploads/thumbnail');
        $crud->callback_after_upload(array($this, 'featured_upload'));

        // Misc
        $crud->columns('title', 'template', 'Generate Module', 'slug');
        $crud->required_fields('title', 'slug', 'view');
        $crud->display_as('slug', 'Link');
        $crud->unset_texteditor('description', 'full_text');
        $crud->unset_export();
        $crud->unset_print();
        $crud->unset_read();
        $crud->add_action('View', 'fa fa-eye', '', '', array($this, 'link_view_page'));

        $crud->set_theme('flexigrid');
        $data = (array) $crud->render();

        $this->layout->set_privilege(1);
        $this->layout->set_wrapper('grocery_builder', $data, 'page', false);
        $this->layout->auth();

        // CSS and JS plugins
        $template_data['css_plugins'] = [
            base_url('assets/plugins/highlightjs/styles/tomorrow-night-eighties.css')
        ];
        $template_data['js_plugins'] = [
            base_url('assets/plugins/highlightjs/highlight.pack.js'),
            base_url('assets/plugins/clipboard/dist/clipboard.min.js'),
            base_url('assets/js/builder.js')
        ];
        $template_data['grocery_css'] = $data['css_files'];
        $template_data['grocery_js'] = $data['js_files'];
        $template_data['title'] = 'Page Builder';
        $template_data['crumb'] = [
            'Page Builder' => '',
        ];

        if ($this->uri->segment(3) != 'add' && $this->uri->segment(3) != 'edit') {
            $this->layout->setCacheAssets();
        }

        $this->layout->render('admin', $template_data);
    }

    /**
     * Featured image upload compress.
     *
     * @return Image
     **/
    public function featured_upload($uploader_response, $field_info, $files_to_upload)
    {
        $this->load->library('image_moo');
        $file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name;

        $this->image_moo->load($file_uploaded)->resize_crop(350, 200)->save($file_uploaded, true);

        return true;
    }

    /**
     * Link view generated page.
     *
     * @return string
     **/
    public function link_view_page($primary_key, $row)
    {
        $this->db->where('id_page', $primary_key);
        $get_slug = $this->db->get('page')->row()->slug;

        return site_url('page').'/'.$get_slug;
    }

    /**
     * Callback input radio Template Frontend or Backend.
     *
     * @return HTML
     **/
    public function template_page($value = '', $primary_key = null)
    {
        $checked['front'] = '';
        $checked['back'] = '';
        if ($value != '') {
            switch ($value) {
                case 'frontend':
                    $checked['front'] = 'checked="checked"';
                    break;
                case 'backend':
                    $checked['back'] = 'checked="checked"';
                    break;
            }
        } else {
            $checked['front'] = 'checked="checked"';
        }
        $front = '<label><input type="radio" name="template" value="frontend" '.$checked['front'].' class="check"> Frontend</label>';
        $back = '<label><input type="radio" name="template" value="backend" '.$checked['back'].' class="check"> Backend</label>';

        return '<div class="radio">'.$front.$back.'</div>';
    }

    /**
     * Callback Slug if exist.
     *
     * @return array
     **/
    public function slug_page_check($post_array, $primary_key)
    {
        $slug = $post_array['slug'];
        $lower = strtolower($slug);
        $slug = str_replace(' ', '-', $lower);

        $this->db->where('slug', $slug);
        $get = $this->db->get('page');
        if ($get->num_rows() != 0) {
            if ($get->row()->id_page != $primary_key) {
                $slug = $slug.$get->num_rows();
            }
        }
        $post_array['slug'] = $slug;

        // Option breadcrumb link
        foreach ($post_array['label'] as $key => $value) {
            if ($value != '') {
                $link = $post_array['link'][$key] != '' ? $post_array['link'][$key] : '';
                $crumbArray[] = ['label' => $value, 'link' => $link];
            }
        }
        $post_array['breadcrumb'] = json_encode($crumbArray);

        return $post_array;
    }

    /**
     * Link slug use in menu.
     *
     * @return string
     **/
    public function slug_page_link($value, $row)
    {
        return $this->template_link('page/'.$value);
    }

    /**
     * Template link.
     *
     * @return HTML
     **/
    public function template_link($link)
    {
        return '<div class="link"><a class="copy-link"><i class="fa fa-copy"></i></a> <input type="text" class="form-link" value="'.$link.'" ></div>';
    }

    /**
     * Custom page backend.
     *
     * @return HTML
     **/
    public function page($slug)
    {
        last_url('set'); // save last url

        $this->db->where('slug', $slug);
        $data['content'] = $this->db->get('page')->row();

        if ($data['content']) {
            $template_data['title'] = $data['content']->title;
            if ($data['content']->breadcrumb != 'null') {
                $crumbs = json_decode($data['content']->breadcrumb);
                foreach ($crumbs as $value) {
                    $add_crumb[$value->label] = $value->link;
                }
            } else {
                $add_crumb['page'] = '';
            }
            $template_data['crumb'] = $add_crumb;

            // Set meta tags
            if ($data['content']->title != '') {
                $this->layout->set_title($data['content']->title);
            }
            if ($data['content']->keyword != '') {
                $this->layout->set_meta_tags('keyword', $data['content']->keyword);
            }
            if ($data['content']->description != '') {
                $this->layout->set_meta_tags('description', $data['content']->description);
            }

            // Set schema
            $this->layout->set_schema('og:site_name', $this->title);
            $this->layout->set_schema('og:title', $data['content']->title);
            $image = $data['content']->featured_image != '' ? base_url('assets/uploads/thumbnail/'.$data['content']->featured_image) : base_url($this->logo);
            $this->layout->set_schema('og:image', $image);
            if ($data['content']->description != '') {
                $this->layout->set_schema('og:description', $data['content']->description);
            }

            // Template
            if ($data['content']->template == 'backend') {
                $template = 'admin';
                $this->layout->auth();
            } else {
                $template = 'front';
            }

            // View wrapper
            if ($data['content']->view == 'default') {
                $this->layout->set_wrapper('page', $data);
            } else {
                $this->layout->set_wrapper('page/'.$data['content']->view, $data);
            }
            $this->layout->setCacheAssets();
            $this->layout->render($template, $template_data);
        } else {
            show_404();
        }
    }

    /**
     * CRUD Builder.
     *
     * @return HTML
     **/
    public function crud_builder()
    {
        last_url('set'); // save last url
        $this->load->library('Grocery_CRUD');
        $crud = new grocery_CRUD();

        $crud->set_table('table');
        $crud->set_subject('Table');
        $crud->required_fields('table_name', 'subject', 'title');
        $crud->fields('table_name', 'subject', 'title', 'action', 'breadcrumb','add_relation_n_n','table_config');

        // All callback
        $crud->callback_field('breadcrumb', array($this, 'breadcrumb_callback'));
        $crud->callback_field('add_relation_n_n', array($this, 'add_relation_n_n_callback'));
        $crud->callback_field('action', array($this, 'action_callback'));
        $crud->callback_column('Generate Module', array($this, 'export_php_callback'));

        // Trigger save
        $crud->callback_before_insert(array($this, 'table_options_save'));
        $crud->callback_before_update(array($this, 'table_options_save'));

        // Misc
        $crud->callback_column('link', array($this, 'link_table'));
        $crud->unset_texteditor('action', 'full_text');
        $crud->unset_texteditor('table_config', 'full_text');
        $crud->unset_read();
        $crud->unset_export();
        $crud->unset_print();
        $crud->columns('title', 'table_name', 'Generate Module', 'link');
        $crud->add_action('View', 'fa fa-eye', '', '', array($this, 'link_view_table'));
        $crud->display_as('relation_1', 'Relation 1-n');
        $crud->display_as('add_relation_n_n', 'Relation n-n');

        $tables = $this->listTable();
        foreach ($tables as $value) {
            $list_tables[$value] = $value;
        }
        $crud->field_type('table_name', 'dropdown', $list_tables);

        $crud->set_theme('flexigrid');
        $data = (array) $crud->render();

        // CSS and JS plugins
        $template_data['css_plugins'] = [
            base_url('assets/plugins/highlightjs/styles/tomorrow-night-eighties.css')
        ];

        $template_data['js_plugins'] = [
            base_url('assets/plugins/highlightjs/highlight.pack.js'),
            base_url('assets/plugins/clipboard/dist/clipboard.min.js'),
            base_url('assets/js/builder.js')
        ];

        $this->layout->set_privilege(1);
        $this->layout->set_wrapper('grocery_builder', $data, 'page', false);
        $this->layout->auth();

        $template_data['grocery_css'] = $data['css_files'];
        $template_data['grocery_js'] = $data['js_files'];
        $template_data['title'] = 'CRUD Builder';
        $template_data['crumb'] = [
            'CRUD Builder' => '',
        ];

        $this->layout->setCacheAssets();

        $this->layout->render('admin', $template_data);
    }

    public function listTable()
    {
        $get_tables = $this->db->list_tables();
        $exception = [
        'table',
        'menu',
        'groups',
        'groups_menu',
        'login_attempts',
        'users',
        'users_groups',
        'page',
        'migrations',
        'menu_type',
        'login',
        'logs'
        ];
        return array_diff($get_tables, $exception);
    }

    /**
     * Create module
     * @return JSON
     */
    public function createModule()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');

            $this->db->where('id_table', $id);
            $table = $this->db->get('table')->row();
            $data = [
            'table' => $table,
            'method' => $this->export_php($id, 'table', true)
            ];

            $controllers = $this->load->view('export_controller', $data, true);

            $structure = './application/modules/' . $table->table_name . '/controllers';
            if (!mkdir($structure, 0777, true)) {
                $status = ['status' => false];
            } else {
                $myfile = fopen($structure . '/' . ucfirst($table->table_name) . '.php', "w");
                fwrite($myfile, $controllers);
                fclose($myfile);

                $status = [
                'status' => true,
                'table' => $table->table_name
                ];
            }
        } else {
            $status = ['status' => false];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($status));
    }

    /**
     * List tables in select option.
     *
     * @return HTML
     **/
    public function list_fields($value = '', $primary_key = '')
    {
        $selectedCol = '';
        if ($primary_key != '') {
            $this->db->where('id_table', $primary_key);
            $table_name = $this->db->get('table')->row()->table_name;
            $columns = $value != '' ? json_decode($value) : [];
            if ($table_name) {
                $list_tables = $this->db->list_fields($table_name);
                $selected = '';
                foreach ($list_tables as $value) {
                    $selected = in_array($value, $columns) ? 'selected="selected"' : '';
                    $selectedCol .= '<option value="'.$value.'" '.$selected.'>'.$value.'</option>';
                }
            }
        }

        return $selectedCol;
    }

    /**
     * Ajax list table.
     *
     * @return HTML
     **/
    public function get_list_fields($table)
    {
        $list_tables = $this->db->field_data($table);
        $id = $this->input->get('id');

        $data['fields'] = $list_tables;
        $data['fieldsType'] = [
            'input' => 'Text',
            'text' => 'Textarea',
            'select' => 'Select',
            'select_multiple' => 'Select Multiple',
            'password' => 'Password',
            'file' => 'File',
            'datetime' => 'Date Time',
            'date' => 'Date',
            'number' => 'Number',
            'true_false' => 'Yes / No',
            'wysiwyg' => 'Text Editor',
            'checkbox' => 'Checkboxes',
            'enum' => 'Options'
            // 'dropdown' => 'Custom Select',
            // 'checkbox_custom' => 'Custom Checkboxes',
            // 'multiselect' => 'Custom Multiple'
        ];
        $data['table'] = $this->listTable();

        $data['Jfields'] = null;
        if ($id) {
            $this->db->where('id_table', $id);
            $this->db->where('table_name', $table);
            $table = $this->db->get('table')->row();
            if ($table != null) {
                $data['Jfields'] = (array) json_decode($table->table_config);
            }
        }

        $viewList = $this->load->view('list_fields', $data, true);
        $this->output->set_content_type('application/json')->set_output(json_encode($viewList));
    }

    public function getFields($table)
    {
        $data =  $this->db->field_data($table);
        $data = json_encode($data);
        //dump_exit($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }

    /**
     * Form select multiple column to view.
     *
     * @return HTML
     **/
    public function columns_callback($value = '', $primary_key = null)
    {
        $viewList = $this->load->view('table_config', [], true);
        $this->output->set_content_type('application/json')->set_output(json_encode($viewList));
    }

    /**
     * Action table.
     *
     * @return HTML
     **/
    public function action_callback($value = '', $primary_key = null)
    {
        if ($value != '') {
            $check = json_decode($value);
        }

        $crud = ['Create', 'Read', 'Update', 'Delete'];
        $form = '';
        $form .= '<input type="text" name="action[]" value="Action" class="hidden">';
        foreach ($crud as $action) {
            if (isset($check)) {
                if (in_array($action, $check)) {
                    $checked = 'checked="checked"';
                } else {
                    $checked = '';
                }
            } else {
                $checked = 'checked="checked"';
            }
            $form .= '<label><input type="checkbox" name="action[]" value="'.$action.'" '.$checked.' class="check"> '.$action.'</label>';
        }

        return '<div class="checkbox" style="margin-left:-19px">'.$form.'</div>';
    }

    /**
     * Return form.
     *
     * @return HTML
     **/
    public function breadcrumb_callback($value = '', $primary_key = null)
    {
        $crumbContent = '<div class="breadcrumb-content">';
        $listCrumb = '';
        $endCrumbContent = '</div><button type="button" class="btn btn-default btn-sm btn-block btn-flat" id="addBreadcrumb"><i class="fa fa-plus-circle"></i> Add Breadcrumb</button>';

        if ($value != 'NULL' && $value != '') {
            $decodeCrumb = json_decode($value);
            if ($decodeCrumb) {
                foreach ($decodeCrumb as $value) {
                    $listCrumb .= $this->breadcrumb_form($value->label, $value->link);
                }
            } else {
                $listCrumb = $this->breadcrumb_form('', '');
            }
        } else {
            $listCrumb .= $this->breadcrumb_form();
        }

        return $crumbContent.$listCrumb.$endCrumbContent;
    }

    /**
     *
     @return HTML
    */
    public function add_relation_n_n_callback($value = '', $primary_key = null)
    {
        $vars['tables'] = $this->listTable();
        $output = $this->load->view('popups/myigniter/add_relation_n_n_callback', $vars, true);
        $output .= '<button type="button" class="btn btn-warning btn-sm btn-block btn-flat" data-toggle="modal" href="#relationNNForm"><i class="fa fa-plus-circle"></i> Add New Relation n-n field</button>';
        return $output;
    }

    /**
     * Return input breadcrumb.
     *
     * @return HTML
     **/
    public function breadcrumb_form($val_label = '', $val_link = '')
    {
        $crumbItem = '<div class="row form-breadcrumb">
        <div class="col-xs-4">						
         <input type="text" name="label[]" value="'.$val_label.'" id="inputLabel" class="form-control" placeholder="Label">
         <br>
     </div>
     <div class="col-xs-6">
         <input type="text" name="link[]" value="'.$val_link.'" id="inputLabel" class="form-control" placeholder="Link">
         <br>
     </div>
     <div class="col-xs-2">
         <button type="button" class="remove-crumb btn btn-danger btn-flat btn-block">
            <i class="fa fa-times-circle"></i>
        </button>
        <br>
    </div>
</div>';
        return $crumbItem;
    }

    /**
     * Save custom option table.
     *
     * @return json
     **/
    public function table_options_save($post_array)
    {
        // Field return JSON
        $fields_json = ['columns', 'field', 'required', 'uploads', 'relation_1', 'action'];
        foreach ($fields_json as $field) {
            if (isset($post_array[$field])) {
                foreach ($post_array[$field] as $key => $value) {
                    $fields[] = $value;
                }
                $post_array[$field] = json_encode($fields);
            } else {
                $post_array[$field] = '';
            }
            unset($fields);
        }

        // Option breadcrumb link
        foreach ($post_array['label'] as $key => $value) {
            if ($value != '') {
                $link = $post_array['link'][$key] != '' ? $post_array['link'][$key] : '';
                $crumbArray[] = ['label' => $value, 'link' => $link];
            }
        }
        $post_array['breadcrumb'] = json_encode($crumbArray);

        // Option Relation 1-n
        foreach ($post_array['relation_1_field'] as $key => $value) {
            if ($value != '') {
                $relation1Array[] = ['field' => $value, 'table_name' => $post_array['relation_1_table_name'][$key], 'field_view' => $post_array['relation_1_field_view'][$key]];
            }
        }
        $post_array['relation_1'] = json_encode($relation1Array);

        return $post_array;
    }

    /**
     * Link view generated table.
     *
     * @return string
     **/
    public function link_view_table($primary_key, $row)
    {
        return site_url('myigniter/table' . '/' . $row->table_name . '__' . $primary_key);
    }

    /**
     * Column link.
     *
     * @return string
     **/
    public function link_table($value, $row)
    {
        return $this->template_link('myigniter/table/' . $row->table_name . '__' . $row->id_table);
    }

    /**
     * Modal Export to PHP.
     *
     * @return string
     **/
    public function export_php_callback($value, $row)
    {
        if (isset($row->id_table)) {
            $id = $row->id_table;
            $builder = 'table';
        } else {
            $id = $row->id_page;
            $builder = 'page';
        }

        return '<a href="#exportPHP" data-id="'.$id.'" data-builder="'.$builder.'" data-toggle="modal" class="btn-php btn btn-success btn-xs"><i class="fa fa-code"></i> Generate Module</a>';
    }

    /**
     * Ajax get PHP Code from CRUD Builder.
     *
     * @return HTML
     **/
    public function export_php($id, $builder, $return = false)
    {
        $data['admin_template'] = $this->admin_template;
        $data['front_template'] = $this->front_template;
        if ($builder == 'table') {
            if ($id != 0) {
                $this->db->where('id_table', $id);
                $data['table'] = $this->db->get('table')->row();
                $tableConfig = json_decode($data['table']->table_config);
                $data['config'] = $this->initializeTable($tableConfig);
                $data['tableConfig'] = $tableConfig;
            } else {
                $table = [];
                foreach ($_POST as $key => $value) {
                    $table[$key] = is_array($value) ? json_encode($value) : $value;
                }
                $table = (object) $table;
                $data['table'] = $table;
                $tableConfig = json_decode($this->input->post('table_config'));
                $data['config'] = $this->initializeTable($tableConfig);
                $data['tableConfig'] = $tableConfig;
            }
            if ($return) {
                return $this->load->view('export_php', $data, true);
            } else {
                echo $this->load->view('export_php', $data, true);
            }
        } else {
            $this->db->where('id_page', $id);
            $data['page'] = $this->db->get('page')->row();
            echo $this->load->view('export_php_page', $data, true);
        }
    }

    /**
     * View table generated.
     *
     * @return HTML
     **/
    public function table($table_name = null)
    {
        last_url('set'); // save last url
        $tableId = explode('__', $table_name);
        $table_name = $tableId[0];
        $id = $tableId[1];
        $this->db->where('id_table', $id);
        $this->db->where('table_name', $table_name);
        $table = $this->db->get('table')->row();

        if ($table) {
            $tableConfig = json_decode($table->table_config);
            $this->load->library('Grocery_CRUD');
            $crud = new grocery_CRUD();
            $crud->set_table($table_name);
            $crud->set_subject($table->subject);

            $config = $this->initializeTable($tableConfig);

            // Show in
            $crud->add_fields($config['fieldsAdd']);
            $crud->edit_fields($config['fieldsEdit']);
            $crud->columns($config['columns']);

            // Fields type
            foreach ($config['fieldsType'] as $key => $value) {
                if ($value == 'text' || $value == 'wysiwyg') {
                    if ($value != 'wysiwyg') {
                        $crud->unset_texteditor($key, 'full_text');
                    }
                    $crud->field_type($key, 'text');
                } elseif ($value == 'file') {
                    $crud->set_field_upload($key, 'assets/uploads');
                } elseif ($value == 'select') {
                    $crud->set_relation($key, $config['selectData'][$key]->table, $config['selectData'][$key]->labelReff);
                } elseif ($value == 'select_multiple') {
                    $list = [];
                    $tableList = $this->db->get($config['selectData'][$key]->table)->result_array();
                    foreach ($tableList as $listMulty) {
                        $list[$listMulty[$config['selectData'][$key]->fieldReff]] = $listMulty[$config['selectData'][$key]->labelReff];
                    }
                    $crud->field_type($key, 'multiselect', $list);
                } else {
                    $crud->field_type($key, $value);
                }
            }

            // Relation n-n
            foreach ($config['realtionNtoN'] as $key => $value) {
                $crud->set_relation_n_n($value->RNNFieldName, $value->RNNRelationalTable, $value->RNNSelectionTable, $value->RNNPrimaryKeyAliasToThisTable, $value->RNNPrimaryKeyAliasToSelectionTable, $value->RNNTitleField);
            }

            // Validation
            foreach ($config['validation'] as $key => $value) {
                $rules = '';
                foreach ($value as $index => $rule) {
                    if ($index != 0) {
                        $rules .= '|';
                    }
                    if (is_object($rule)) {
                        foreach ($rule as $fieldObject => $val) {
                            $rules .= $fieldObject . '[' . $val . ']';
                            break;
                        }
                    } else {
                        $rules .= $rule;
                    }
                }

                $crud->set_rules($key, ucfirst(str_replace('_', ' ', $key)), $rules);
            }

            // Display As
            foreach ($tableConfig as $key => $value) {
                if (isset($value->alias)) {
                    if ($value->alias != '') {
                        $crud->display_as($key, $value->alias);
                    }
                }
            }

            // Unset action
            if ($table->action != '') {
                $action = json_decode($table->action);
                if (!in_array('Create', $action)) {
                    $crud->unset_add();
                }
                if (!in_array('Read', $action)) {
                    $crud->unset_read();
                }
                if (!in_array('Update', $action)) {
                    $crud->unset_edit();
                }
                if (!in_array('Delete', $action)) {
                    $crud->unset_delete();
                }
            }

            $crud->set_theme('flexigrid');
            $data = (array) $crud->render();
            if ($table->breadcrumb != 'null') {
                $crumbs = json_decode($table->breadcrumb);
                foreach ($crumbs as $value) {
                    $add_crumb[$value->label] = $value->link;
                }
            } else {
                $add_crumb['table'] = '';
            }

            $this->layout->set_wrapper('grocery', $data, 'page', false);
            $this->layout->auth();

            $template_data['grocery_css'] = $data['css_files'];
            $template_data['grocery_js'] = $data['js_files'];

            $template_data['title'] = $table->title;
            $template_data['crumb'] = $add_crumb;
            $this->layout->render('admin', $template_data);
        } else {
            $this->page_404();
        }
    }

    public function initializeTable($table)
    {
        $config = [
            'fieldsAdd' => [],
            'fieldsEdit' => [],
            'fieldsView' => [],
            'fieldsType' => [],
            'columns' => [],
            'selectData' => [],
            'validation' => [],
            'realtionNtoN' => []
        ];

        foreach ($table as $key => $value) {
            // Relation n-n
            if ($key != 'r_n_n') {
                // Show in
                if ($value->actions->add == '1') {
                    $config['fieldsAdd'][] = $key;
                }
                if ($value->actions->edit == '1') {
                    $config['fieldsEdit'][] = $key;
                }
                if ($value->actions->details == '1') {
                    $config['fieldsView'][] = $key;
                }
                if ($value->actions->column == '1') {
                    $config['columns'][] = $key;
                }

                // Fields type
                $value->type = $this->initializeFieldType($value->type);
                $config['fieldsType'][$key] = $value->type;
                if (isset($value->selectData->table)) {
                    $config['selectData'][$key] = $value->selectData;
                }
                if (!empty($value->validation)) {
                    $config['validation'][$key] = $value->validation;
                }
            } else {
                foreach ($value as $index => $val) {
                    // Show in
                    if ($val->RNNAdd == '1') {
                        $config['fieldsAdd'][] = $val->RNNFieldName;
                    }
                    if ($val->RNNEdit == '1') {
                        $config['fieldsEdit'][] = $val->RNNFieldName;
                    }
                    if ($val->RNNDetails == '1') {
                        $config['fieldsView'][] = $val->RNNFieldName;
                    }
                    if ($val->RNNColumn == '1') {
                        $config['columns'][] = $val->RNNFieldName;
                    }
                    $config['realtionNtoN'][] = $val;
                }
            }
        }

        return $config;
    }

    public function initializeFieldType($type)
    {
        if ($type == 'input') {
            $type = 'string';
        }
        if ($type == 'number') {
            $type = 'integer';
        }

        return $type;
    }

    /**
     * Modules management.
     *
     * @return HTML
     **/
    public function modules()
    {
        last_url('set'); // save last url
        $dir = '.'.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'modules';
        $data['modules'] = scandir($dir);

        $template_data['title'] = 'Module Extensions';
        $template_data['crumb'] = array('Module Extensions' => '');

        $this->layout->set_privilege(1);
        $this->layout->set_wrapper('modules', $data);

        $this->layout->setCacheAssets();

        $this->layout->render('admin', $template_data);
    }

    /**
     * Install module.
     **/
    public function module_install()
    {
        $config['upload_path'] = './assets/uploads/module/';
        $config['allowed_types'] = 'zip';
        $config['max_size'] = '';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('module')) {
            $error = array('error' => $this->upload->display_errors());
            echo $error['error'];
        } else {
            $data = array('upload_data' => $this->upload->data());
            $zip = new ZipArchive();
            $file = $data['upload_data']['full_path'];
            chmod($file, 0777);
            if ($zip->open($file)) {
                $zip->extractTo('./application/modules/');
                $zip->close();
                unlink('./assets/uploads/module/'.$data['upload_data']['file_name']);
                redirect('myigniter/modules');
            } else {
                echo 'failed';
            }
        }
    }

    /**
     * Module detail.
     *
     * @return HTML
     **/
    public function module_detail($path)
    {
        if ($this->load->module($path)) {
            $module = modules::run($path.'/module');
            $data['module'] = $module;
        }

        $this->layout->set_wrapper('module_detail', $data);
        $this->layout->auth();

        $template_data['title'] = 'Module Detail';
        $template_data['crumb'] = [
        'Module Extensions' => 'myigniter/modules',
        'Module Detail' => '',
        ];
        $this->layout->render('admin', $template_data);
    }

    /**
     * Delete modules directory and files.
     **/
    public function module_delete($path)
    {
        $dir = '.'.DIRECTORY_SEPARATOR.'application'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$path;
        $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
        redirect('myigniter/modules');
    }

    /**
     * Crud user management.
     *
     * @return HTML
     **/
    public function users()
    {
        last_url('set'); // save last url
        $this->load->library('Grocery_CRUD');
        $crud = new grocery_CRUD();

        $crud->set_table('users');
        $crud->set_subject('Users');

        $this->load->config('grocery_crud');
        $this->config->set_item('grocery_crud_file_upload_allow_file_types', 'gif|jpeg|jpg|png');

        $crud->columns('username', 'email', 'groups', 'active');
        if ($this->uri->segment(3) !== 'read') {
            $crud->add_fields('username', 'photo', 'full_name', 'email', 'groups', 'password', 'password_confirm');
            $admin_group = $this->config->item('admin_group', 'ion_auth');
            if ($this->ion_auth->in_group($admin_group)) {
                $crud->edit_fields('username', 'photo', 'full_name', 'email', 'groups', 'last_login', 'old_password', 'new_password');
                $crud->set_relation_n_n('groups', 'users_groups', 'groups', 'user_id', 'group_id', 'name');
            } else {
                $crud->edit_fields('username', 'photo', 'full_name', 'email', 'last_login', 'old_password', 'new_password');
            }
        } else {
            $crud->set_read_fields('username', 'photo', 'full_name', 'email', 'last_login');
        }
        // Image social media
        if ($this->uri->segment(3) == 'read' || $this->uri->segment(3) == 'edit') {
            $id = $this->uri->segment(4);
            $this->db->where('id', $id);
            $checkUser = $this->db->get('users')->row();
            $checkImg = explode('http', $checkUser->photo);
            if (isset($checkImg[1])) {
                $crud->callback_edit_field('photo', array($this, 'fieldPhotoUsers'));
            }
        }
        $crud->callback_column('groups', array($this, 'groups_users'));

        // Validation
        $crud->required_fields('us ername', 'full_name', 'email', 'password', 'password_confirm');
        $crud->set_rules('email', 'E-mail', 'required|valid_email');
        $crud->set_rules('password', 'Password', 'required|min_length['.$this->config->item('min_password_length', 'ion_auth').']|max_length['.$this->config->item('max_password_length', 'ion_auth').']|matches[password_confirm]');
        $crud->set_rules('new_password', 'New password', 'min_length['.$this->config->item('min_password_length', 'ion_auth').']|max_length['.$this->config->item('max_password_length', 'ion_auth').']');

        // Field types
        $crud->change_field_type('last_login', 'readonly');
        $crud->change_field_type('password', 'password');
        $crud->change_field_type('password_confirm', 'password');
        $crud->change_field_type('old_password', 'password');
        $crud->change_field_type('new_password', 'password');
        $crud->set_field_upload('photo', 'assets/uploads/image');

        // Callbacks
        $crud->callback_insert(array($this, 'create_user_callback'));
        $crud->callback_update(array($this, 'edit_user_callback'));
        $crud->callback_field('last_login', array($this, 'last_login_callback'));
        $crud->callback_column('active', array($this, 'active_callback'));
        $crud->callback_after_upload(array($this, 'avatar_upload'));
        $crud->callback_delete(array($this, 'delete_user'));

        if ($this->uri->segment(3) == 'profile') {
            $crud->unset_back_to_list();
        }
        $crud->set_theme('flexigrid');

        $data = (array) $crud->render();
        if ($this->uri->segment(4) != 'edit' || $this->uri->segment(5) != $this->ion_auth->user()->row()->id) {
            $this->layout->set_privilege(1);
        }

        $this->layout->set_wrapper('grocery', $data, 'page', false);
        $this->layout->auth();

        $template_data['grocery_css'] = $data['css_files'];
        $template_data['grocery_js'] = $data['js_files'];

        $template_data['title'] = 'Users';
        $template_data['crumb'] = [
            'Users' => '',
        ];

        $this->layout->setCacheAssets();

        $this->layout->render('admin', $template_data);
    }

    /**
     * Magic Image URL
     * @param  string $value
     * @param  integer $primary_key
     * @return html
     */
    public function fieldPhotoUsers($value = "", $primary_key = null)
    {
        $html = '<img src="' . $value . '" height="50px">';
        return $html;
    }

    /**
     * Call back groups.
     *
     * @param string $value
     * @param string $row
     *
     * @return Groups
     */
    public function groups_users($value, $row)
    {
        $id_groups[] = 0;
        $return = '';
        $this->db->where('user_id', $row->id);
        $users_groups = $this->db->get('users_groups')->result();
        if ($users_groups) {
            foreach ($users_groups as $value) {
                $id_groups[] = $value->group_id;
            }
            $this->db->where('id in('.implode(',', $id_groups).')');
            $groups = $this->db->get('groups')->result();
            if ($groups) {
                foreach ($groups as $value) {
                    $groups_name[] = $value->name;
                }
                $return = implode(', ', $groups_name);
            }
        }

        return $return;
    }

    /**
     * Avatar upload compress.
     *
     * @return Image
     **/
    public function avatar_upload($uploader_response, $field_info, $files_to_upload)
    {
        $this->load->library('image_moo');
        $file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name;

        $this->image_moo->load($file_uploaded)->resize_crop(160, 160)->save($file_uploaded, true);

        return true;
    }

    /**
     * Crud users group.
     *
     * @return HTML
     **/
    public function groups()
    {
        last_url('set'); // save last url
        $this->load->library('Grocery_CRUD');
        $crud = new grocery_CRUD();

        $crud->set_table('groups');
        $crud->set_subject('Groups');
        $crud->set_theme('flexigrid');
        $crud->callback_after_insert(array($this, 'afterInsertGroup'));
        $crud->callback_after_update(array($this, 'afterUpdateGroup'));
        $crud->callback_after_delete(array($this, 'afterDeleteGroup'));

        $data = (array) $crud->render();

        $this->layout->set_privilege(1);
        $this->layout->set_wrapper('grocery', $data, 'page', false);
        $this->layout->auth();

        $template_data['grocery_css'] = $data['css_files'];
        $template_data['grocery_js'] = $data['js_files'];

        $template_data['title'] = 'Groups';
        $template_data['crumb'] = [
            'Groups' => '',
        ];

        $this->layout->setCacheAssets();

        $this->layout->render('admin', $template_data);
    }

    /**
     * Log group
     * @param  Array $post_array
     * @param  Integer $primary_key
     * @return Boolean
     */
    public function afterInsertGroup($post_array, $primary_key)
    {
        $this->load->model('logs');
        $dataLog = [
        'status' => true,
        'id' => $primary_key,
        'name' => $post_array['name'],
        'ip' => $this->input->ip_address()
        ];
        $this->logs->addLogs('insert_group', $dataLog);

        return true;
    }

    public function afterUpdateGroup($post_array, $primary_key)
    {
        $this->load->model('logs');
        $dataLog = [
        'status' => true,
        'id' => $primary_key,
        'name' => $post_array['name'],
        'ip' => $this->input->ip_address()
        ];
        $this->logs->addLogs('update_group', $dataLog);

        return true;
    }

    public function afterDeleteGroup($primary_key)
    {
        $this->load->model('logs');
        $dataLog = [
        'status' => true,
        'id' => $primary_key,
        'ip' => $this->input->ip_address()
        ];
        $this->logs->addLogs('delete_group', $dataLog);

        return true;
    }

    /**
     * Callback active or inactive user.
     *
     * @return HTML
     **/
    public function active_callback($value, $row)
    {
        if ($value == 1) {
            $val = 'active';
        } else {
            $val = 'inactive';
        }

        return "<a href='".site_url('myigniter/manual_activate/'.$row->id.'/'.$value)."'>$val</a>";
    }

    /**
     * Redirect link after trigger active or deactive user.
     *
     * @return Rerirect
     **/
    public function manual_activate($id, $value)
    {
        if ($value == 1) {
            $this->ion_auth->deactivate($id);
        } else {
            $this->ion_auth->activate($id);
        }

        redirect('myigniter/users');
    }

    /**
     * Callback date & time last login user.
     *
     * @return string
     **/
    public function last_login_callback($value = '', $primary_key = null)
    {
        $value = date('l Y/m/d H:i', $value);

        return $value;
    }

    /**
     * Delete user.
     *
     * @return bool
     **/
    public function delete_user($primary_key)
    {
        if ($this->ion_auth_model->delete_user($primary_key)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Callback manual edit user.
     *
     * @return bool
     **/
    public function edit_user_callback($post_array, $primary_key)
    {
        $this->load->model('logs');
        $identity = $post_array[$this->config->item('identity', 'ion_auth')];
        $groups = $post_array['groups'];
        $old = $post_array['old_password'];
        $new = $post_array['new_password'];
        $data = array(
            'username' => $post_array['username'],
            'email' => $post_array['email'],
            'full_name' => $post_array['full_name'],
            'photo' => $post_array['photo'],
            );
        if ($old != '') {
            $change = $this->ion_auth->update($primary_key, $data) && $this->ion_auth->change_password($identity, $old, $new);
        } else {
            $change = $this->ion_auth->update($primary_key, $data);
        }

        if ($groups) {
            $this->ion_auth->remove_from_group('', $primary_key);
            $this->addGroups($groups, $primary_key);
        }

        if ($change) {
            $dataLog = [
            'status' => true,
            'via' => 'admin',
            'identity' => $data['email'],
            'ip' => $this->input->ip_address()
            ];
            $this->logs->addLogs('update_user', $dataLog);

            return true;
        } else {
            $dataLog = [
            'status' => false,
            'via' => 'admin',
            'message' => str_replace('&times;Close', '', strip_tags($this->ion_auth->errors())),
            'identity' => $data['email'],
            'ip' => $this->input->ip_address()
            ];
            $this->logs->addLogs('update_user', $dataLog);

            return false;
        }
    }

    public function addGroups($groups, $primary_key)
    {
        if ($groups) {
            foreach ($groups as $value) {
                $this->ion_auth->add_to_group($value, $primary_key);
            }
        }
    }

    /**
     * Callback manual add user.
     *
     * @return bool
     **/
    public function create_user_callback($post_array, $primary_key = null)
    {
        $this->load->model('logs');

        $username = $post_array['username'];
        $password = $post_array['password'];
        $email = $post_array['email'];
        $group = $post_array['groups'];
        $data = [
        'full_name' => $post_array['full_name'],
        'photo' => $post_array['photo'],
        ];
        $register = $this->ion_auth->register($username, $password, $email, $data, $group);

        if ($register) {
            $dataLog = [
            'status' => true,
            'via' => 'admin',
            'identity' => $email,
            'ip' => $this->input->ip_address()
            ];
        } else {
            $dataLog = [
            'status' => false,
            'via' => 'admin',
            'message' => str_replace('&times;Close', '', strip_tags($this->ion_auth->errors())),
            'identity' => $email,
            'ip' => $this->input->ip_address()
            ];
        }
        $this->logs->addLogs('register', $dataLog);

        return $register;
    }

    /**
     * Form route load first page.
     *
     * @return HTML
     **/
    public function route_index($value = '', $primary_key = null)
    {
        $checked_page = '';
        $checked_login = '';
        $val = json_decode($value);
        foreach ($val as $key => $value) {
            switch ($key) {
                case 'page':
                    $checked_page = 'checked="checked"';
                    $val_page = $value;
                    break;
                case 'login':
                    $checked_login = 'checked="checked"';
                    break;
                default:
                    $checked_login = 'checked="checked"';
                    break;
            }
        }
        $page = '<label><input type="radio" id="page" name="option_index" value="page" '.$checked_page.' class="check"> Page</label>';
        $login = '<label><input type="radio" name="option_index" value="login" '.$checked_login.' class="check"> Login</label>';

        if ($checked_page != '') {
            return '<div class="radio">'.$page.$login.'</div><br><div id="formPage">'.$this->ajax_form_page($val_page).'</div>';
        } else {
            return '<div class="radio">'.$page.$login.'</div><br><div id="formPage"></div>';
        }
    }

    /**
     * Ajax load form list of page.
     *
     * @return HTML
     **/
    public function ajax_form_page($return = null)
    {
        $page = $this->db->get('page')->result();
        $option = '<option></option>';
        foreach ($page as $value) {
            if ($return != null) {
                if ($value->slug == $return) {
                    $option .= '<option value="'.$value->slug.'" selected="selected">'.$value->title.'</option>';
                } else {
                    $option .= '<option value="'.$value->slug.'">'.$value->title.'</option>';
                }
            } else {
                $option .= '<option value="'.$value->slug.'">'.$value->title.'</option>';
            }
        }
        if ($return != null) {
            return '<br><select name="page" data-placeholder="Select page" class="listPages chosen-select">'.$option.'</select>';
        } else {
            echo '<br><select name="page" data-placeholder="Select page" class="listPages chosen-select">'.$option.'</select>';
        }
    }

    /**
     * Save setting route.
     *
     * @return JSON
     **/
    public function save_route($post_array)
    {
        $option = $post_array['option_index'];
        if ($option == 'page') {
            $page = $post_array['page'];
            $json[$option] = $page;
        } else {
            $json[$option] = 'null';
        }

        $post_array['route'] = json_encode($json);

        return $post_array;
    }

    /**
     * Crud menu type.
     *
     * @return HTML
     **/
    public function menu_type()
    {
        if ($this->uri->segment(4) == 'delete') {
            $id_menu_type = $this->uri->segment(5);
            $this->db->where('id_menu_type', $id_menu_type);
            $this->db->delete('menu_type');

            $this->db->where('id_menu_type', $id_menu_type);
            $menus = $this->db->get('menu')->result();
            foreach ($menus as $menu) {
                $this->db->where('id_menu', $menu->id_menu);
                $this->db->delete('groups_menu');
            }

            $this->db->where('id_menu_type', $id_menu_type);
            $this->db->delete('menu');

            $this->sort_menu_callback(0, $id_menu_type);
            redirect('myigniter/menu/'.$this->uri->segment(3));
        } else {
            $crud = new grocery_CRUD();

            $crud->set_table('menu_type');
            $crud->set_subject('Menu Type');

            $data = (array) $crud->render();
            if ($this->uri->segment(4) != 'add' && $this->uri->segment(4) != 'edit') {
                redirect('myigniter/menu/'.$this->uri->segment(3));
            }

            $this->layout->set_wrapper('grocery', $data, 'page', false);
            $this->layout->auth();

            $template_data['grocery_css'] = $data['css_files'];
            $template_data['grocery_js'] = $data['js_files'];

            $template_data['title'] = 'Menu';
            $template_data['crumb'] = [
            'Menu' => 'myigniter/menu',
            'Menu Type' => '',
            ];
            $this->layout->render('admin', $template_data);
        }
    }

    /**
     * Crud multy level menu.
     *
     * @return HTML
     **/
    public function crud_menu()
    {
        last_url('set'); // save last url
        if ($this->uri->segment(4) == 'delete') {
            $id_menu = $this->uri->segment(5);
            $this->db->where('id_menu', $id_menu);
            $this->db->delete('menu');

            $this->db->where('id_menu', $id_menu);
            $this->db->delete('groups_menu');

            // Delete Children
            $this->db->where('parent_id', $id_menu);
            $get_groups = $this->db->get('menu')->result();
            foreach ($get_groups as $menu) {
                $this->db->where('id_menu', $menu->id_menu);
                $this->db->delete('menu');
            }

            $this->db->where('parent_id', $id_menu);
            $this->db->delete('menu');

            $this->sort_menu_callback(0, $id_menu);
            redirect('myigniter/menu/'.$this->uri->segment(3));
        } else {
            $this->load->library('Grocery_CRUD');
            $crud = new grocery_CRUD();

            $crud->set_table('menu');
            $crud->unset_fields('sort');
            $crud->display_as('parent_id', 'Parent')
            ->display_as('id', 'ID');

            $crud->field_type('label', 'icon', 'link', 'parent_id', 'id');
            $crud->callback_before_insert(array($this, 'auto_level_menu'));
            $crud->callback_before_update(array($this, 'auto_level_menu'));
            $crud->callback_after_insert(array($this, 'sort_menu_callback'));
            $crud->callback_after_update(array($this, 'sort_menu_callback'));
            $crud->change_field_type('level', 'invisible');
            $crud->change_field_type('id_menu_type', 'invisible');
            $crud->callback_field('icon', array($this, 'iconList'));

            $type = urldecode(str_replace('-', ' ', $this->uri->segment(3)));
            $this->db->where('type', $type);
            $get_id = $this->db->get('menu_type', $type)->row();
            if ($get_id) {
                $id_menu_type = $get_id->id_menu_type;
            } else {
                $id_menu_type = 1;
            }

            $crud->set_subject('Admin menu');
            $crud->set_relation_n_n('Privilage', 'groups_menu', 'groups', 'id_menu', 'id_groups', 'name');

            $this->db->order_by('sort', 'asc');
            $this->db->where('id_menu_type', $id_menu_type);
            $label_side_menu = $this->db->get('menu')->result();
            if ($label_side_menu) {
                foreach ($label_side_menu as $nav) {
                    $label[$nav->id_menu] = $nav->label;
                }
            } else {
                $label[] = '';
            }

            $crud->field_type('parent_id', 'dropdown', $label);

            $data = (array) $crud->render();
            if ($this->uri->segment(4) != 'add' && $this->uri->segment(4) != 'edit') {
                redirect('myigniter/menu/'.$this->uri->segment(3));
            }

            $this->layout->set_wrapper('grocery', $data, 'page', false);
            $this->layout->auth();

            $template_data['grocery_css'] = $data['css_files'];
            $template_data['grocery_js'] = $data['js_files'];
            $template_data['title'] = 'Menu';
            $template_data['crumb'] = ['Menu' => ''];

            $this->layout->render('admin', $template_data);
        }
    }

    /**
     * List icon picker
     * @param  string   $value
     * @param  integer  $primary_key
     * @return html
     */
    public function iconList($value = '', $primary_key = null)
    {
        $data['value'] = $value;
        return $this->load->view('icons', $data, true);
    }

    /**
     * Resort menu.
     *
     * @return bool
     **/
    public function sort_menu_callback($post_array, $primary_key)
    {
        $this->db->where('id_menu', $primary_key);
        $id_menu_type = $this->db->get('menu')->row()->id_menu_type;
        $menu_json = json_encode($this->menu_re_sort($id_menu_type));
        $this->update_menu($menu_json, false);

        return true;
    }

    /**
     * Callback Auto fill level menu.
     *
     * @return array
     **/
    public function auto_level_menu($post_array)
    {
        $type = urldecode(str_replace('-', ' ', $this->uri->segment(3)));
        $this->db->where('type', $type);
        $get_type = $this->db->get('menu_type')->row();
        if ($get_type) {
            $id_menu_type = $get_type->id_menu_type;
        } else {
            $id_menu_type = 1;
        }
        $post_array['id_menu_type'] = $id_menu_type;
        $level = 0;
        if (!$post_array['parent_id']) {
            $post_array['parent_id'] = 0;
            $post_array['level'] = $level;
        } else {
            $this->db->where('id_menu', $post_array['parent_id']);
            $get_level = $this->db->get('menu')->row()->level;

            $post_array['level'] = $get_level + 1;
        }

        return $post_array;
    }

    /**
     * Nestable drag & drop menu level & sort.
     *
     * @return HTML
     **/
    public function menu($type = 'side menu')
    {
        last_url('set'); // save last url
        $data['menu_type'] = $this->db->get('menu_type')->result();
        $type = urldecode(str_replace('-', ' ', $type));
        $data['admin_menu'] = $this->get_menu($type);

        $template_data['css_plugins'] = [base_url('assets/plugins/jquery-nestable/jquery.nestable.css')];
        $template_data['js_plugins'] = [base_url('assets/plugins/jquery-nestable/jquery.nestable.js')];

        $this->layout->set_privilege(1);
        $this->layout->set_wrapper('menu', $data);
        $this->layout->auth();

        $template_data['title'] = 'Menu';
        $template_data['crumb'] = [
            'Menu' => '',
        ];

        $this->layout->setCacheAssets();

        $this->layout->render('admin', $template_data);
    }

    /**
     * Get db menu nestable.
     *
     * @return string
     **/
    public function get_menu($type)
    {
        $this->db->where('type = "'.$type.'"');
        $this->db->join('menu_type', 'menu_type.id_menu_type = menu.id_menu_type', 'left');
        $this->db->order_by('sort', 'ASC');
        $menus = $this->db->get('menu')->result_array();

        return $this->get_nestable_menu($menus);
    }

    /**
     * Show list nestable menu.
     *
     * @return string
     **/
    public function get_nestable_menu($menus, $parent_id = 0)
    {
        $list_menu = '';
        foreach ($menus as $menu) {
            if ($parent_id == $menu['parent_id']) {
                $type = urldecode(str_replace(' ', '-', strtolower($menu['type'])));
                $list_menu .= '<li class="dd-item" data-id="'.$menu['id_menu'].'">
                <div class="dd-handle bg-light-blue"><i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i></div><p>'.$menu['label'].'
                <span class="dd-action">
                  <a href="'.site_url('myigniter/crud_menu/'.$type.'/edit/'.$menu['id_menu']).'" title="edit"><i class="fa fa-pencil"></i></a>
                  <a href="'.site_url('myigniter/crud_menu/'.$type.'/delete/'.$menu['id_menu']).'" title="Delete" class="delete-confirm"><i class="fa fa-trash"></i></a>
              </span></p>';
                $list_menu .= $this->get_nestable_menu($menus, $menu['id_menu']);
                $list_menu .= '</li>';
            }
        }

        if ($list_menu != '') {
            return '<ol class="dd-list">'.$list_menu.'</ol>';
        } else {
            return;
        }
    }

    /**
     * Re order SORT menu DB.
     *
     * @return array
     **/
    public function menu_re_sort($id_menu_type)
    {
        $this->db->where('id_menu_type = "'.$id_menu_type.'"');
        $this->db->order_by('sort', 'ASC');
        $menus = $this->db->get('menu')->result_array();

        return $this->get_re_sort($menus);
    }

    /**
     * Re order SORT menu.
     *
     * @return array
     **/
    public function get_re_sort($menus, $parent_id = 0)
    {
        $menu_array = null;
        foreach ($menus as $menu) {
            if ($parent_id == $menu['parent_id']) {
                $children = $this->get_re_sort($menus, $menu['id_menu']);
                if ($children) {
                    $menu_array[] = ['id' => $menu['id_menu'], 'children' => $children];
                } else {
                    $menu_array[] = ['id' => $menu['id_menu']];
                }
            }
        }

        return $menu_array;
    }

    /**
     * Update menu.
     *
     * @return redirect
     **/
    public function update_menu($menu = null, $return = true)
    {
        if ($menu == null) {
            $type = $this->input->post('type');
            $menu = $this->input->post('json_menu');
        }
        $decode = json_decode($menu);

        $this->decode_menu($decode);
        if ($return) {
            redirect('myigniter/menu/'.$type);
        }
    }

    /**
     * Save menu into database.
     *
     * @return array
     **/
    public function decode_menu($menu, $parent_id = null, $level = null, $sort = null)
    {
        if ($parent_id == null && $level == null) {
            $parent_id = 0;
            if ($this->uri->segment(3) == 'side_menu') {
                $level = 0;
            } else {
                $level = 1;
            }
        }

        if ($sort == null) {
            $sort = 0;
        }
        foreach ($menu as $value) {
            $update_menu = ['sort' => $sort, 'id_menu' => $value->id, 'level' => $level, 'parent_id' => $parent_id];

            $this->db->where('id_menu', $value->id);
            $this->db->update('menu', $update_menu);
            ++$sort;

            if (isset($value->children)) {
                $sort = $this->decode_menu($value->children, $value->id, $level + 1, $sort);
            }
        }

        return $sort;
    }

    /**
     * Error 404.
     *
     * @return HTML
     **/
    public function page_404()
    {
        $this->output->set_status_header('404');
        $this->layout->set_wrapper('error_page/error_404');
        $this->layout->render();
    }

    /**
     * Database management.
     *
     * @return HTML
     **/
    public function database()
    {
        last_url('set'); // save last url

        $this->layout->set_privilege(1);

        $data['tables'] = $this->listTable();
        // $data['tables'][] = 'menu';

        $template_data['css_plugins'] = [
        base_url('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css'),
        ];
        
        $template_data['js_plugins'] = [
        base_url('assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js'),
        base_url('assets/js/db_manager.js'),
        ];
        
        $template_data['title'] = 'Database Manager';
        $template_data['crumb'] = array('Database Manager' => '');
        
        $data['type'] = [
            'Numeric' => ['INT', 'TINYINT', 'SMALLINT', 'MEDIUMINT', 'BIGINT', 'FLOAT', 'DOUBLE', 'DECIMAL'],
            'Time' => ['DATE', 'DATETIME', 'TIMESTAMP', 'TIME', 'YEAR'],
            'String' => ['CHAR', 'VARCHAR', 'TEXT', 'TINYTEXT', 'MEDIUMTEXT', 'LONGTEXT', 'ENUM'],
            'binary' => ['BLOB', 'TINYBLOB', 'MEDIUMBLOB', 'LONGBLOB']
        ];
        
        $this->layout->set_wrapper('database', $data);

        $this->layout->setCacheAssets();

        $this->layout->render('admin', $template_data);
    }

    /**
     *  drop database table
     *  @return 1 on success 0 on fail
     */
    public function delete_table()
    {
        if ($this->input->is_ajax_request()) {
            $table_name = $this->input->post('table_name');
            $this->drop_table($table_name);
            $data = '{"status":"1"}';
            $this->output->set_content_type('application/json')->set_output($data);
        }
    }

    /**
     *  migrate database table
     *  @return 1 on success 0 on fail
     */
    public function generate_migration_file()
    {
        if ($this->input->is_ajax_request()) {
            $table_name = $this->input->post('table_name');
            $this->db->where('module', 'CI_core');
            $migrations = $this->db->get('migrations')->row();
            $version = 1;
            if ($migrations) {
                $version = $migrations->version + 1;
            }
            $data = $this->write_migration_file($table_name, $version);
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }

    /**
     *  drop database table
     *  @return 1 on success 0 on fail
     */
    public function add_table()
    {
        $this->load->dbforge();

        if (! $this->input->is_ajax_request()) {
            die('No direct access allowed here');
        }

        $table_name = $this->input->post('table_name');
        $fields = $this->input->post('field');

        if (trim($table_name) == "") {
            return $this->_set_output_json('Table name is required', '0');
        }


        $data = [];
        $keys = []; //primary_key

        foreach ($fields as $key => $value) {
            array_shift($fields[$key]);
        }

        if (count($fields['name']) == 0 || trim($fields['name'][0]) == "") {
            return $this->_set_output_json('You must at least add one field for table', '0');
        }

        foreach ($fields as $key => $val) {
            if ($key == 'name') {
                foreach ($fields['name'] as $f) {
                    $data[$f] = [];
                }
            }

            if ($key == 'type') {
                $i =0;
                foreach ($data as $index => $Dvalue) {
                    $data[$index]['type'] = $fields['type'][$i];
                    $data[$index]['constraint'] = $fields['length'][$i];

                    // validate length
                    $this->_validate_fields_length($index, $data[$index]['type'], $data[$index]['constraint']);

                    if ($fields['value'][$i] === 'Auto Increment') {
                        $data[$index]['auto_increment'] = true;
                        $keys[] = $index;
                    }

                    if ($fields['value'][$i] === 'NULL') {
                        $data[$index]['default'] = null;
                    }

                    if ($fields['primary_key'][$i] == 1) {
                        $keys[] = $index;
                    }

                    if ($fields['unsigned'][$i] == 1) {
                        $data[$index]['unsigned'] = true;
                    }

                    if ($fields['null'][$i] == 1) {
                        $data[$index]['null'] = true;
                    }

                    if ($fields['zerofill'][$i] == 1) {
                        $data[$index]['default'] = 0;
                    }
                    $i++;
                }
            }
        }

        $this->dbforge->add_field($data);
        $this->dbforge->add_key($keys, true);
        $this->dbforge->create_table($table_name, true);

        return $this->_set_output_json('Table created, thanks', '1');
    }

    private function _validate_fields_length($field_name, $type, $constraint)
    {
        $needed_length_arr = ['INT','CHAR','CHARACHTER','TINYINT'];
        if (in_array($type, $needed_length_arr) and ($constraint == "" or $constraint == 0)) {
            return $this->_set_output_json('Field <b>'.$field_name.'</b> must have lenght', '0');
        }
    }

    private function _set_output_json($message, $state)
    {
        $response = new stdClass();
        $response->message = $message;
        $response->state = $state;
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
}

/* End of file Crud.php */
/* Location: ./application/controllers/Crud.php */

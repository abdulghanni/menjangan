<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Documentation extends MY_Controller
{
    private $title;
    private $front_template;
    private $admin_template;

    /**
     * Modules instalation.
     *
     * @return JSON
     **/
    public function module()
    {
        $module = [
            'name' => 'Documentation',
            'menu_link' => ['documentation/welcome' => 'View documentation'],
            'table' => '',
            'description' => 'Documentation myigniter',
        ];

        return $module;
    }

    public function __construct()
    {
        parent::__construct();

        $this->title = 'Documentation';
        $this->front_template = 'template/front_template';
        $this->admin_template = 'template/admin_template';
    }

    public function index()
    {
        $template_data['css_plugins'] = [base_url('assets/plugins/highlightjs/styles/tomorrow-night-eighties.css')];
        $template_data['js_plugins'] = [base_url('assets/plugins/highlightjs/highlight.pack.js')];

        $this->layout->set_title($this->title . ' - Quick Start');
        $this->layout->set_wrapper('start');

        $this->layout->setCacheAssets();

        $this->layout->render('front', $template_data);
    }

    public function welcome()
    {
        $this->layout->auth();

        $template_data['css_plugins'] = [base_url('assets/plugins/highlightjs/styles/tomorrow-night-eighties.css')];
        $template_data['js_plugins'] = [base_url('assets/plugins/highlightjs/highlight.pack.js')];

        $template_data['title'] = 'Documentation';
        $template_data['crumb'] = [
            'Documentation' => ''
        ];

        $this->layout->set_title($this->title);
        $this->layout->set_wrapper('welcome');

        $this->layout->setCacheAssets();

        $this->layout->render('admin', $template_data);
    }
}

/* End of file documentation.php */
/* Location: ./application/controllers/documentation.php */

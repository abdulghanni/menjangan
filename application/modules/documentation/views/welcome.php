<h1>Welcome to myigniter</h1>
<p>myIgniter is a custom PHP framework that let build web application as fast as possible. With the main features CRUD Generator and PAGE Generator.</p>
<h2><a href="#documentation" id="documentation">#</a> Documentation</h2>
<ul>
    <li><a href="https://www.codeigniter.com/user_guide/" target="_blank">Codeigniter</a></li>
    <li><a href="http://www.grocerycrud.com/documentation/options_functions/" target="_blank">Grocery CRUD</a></li>
    <li><a href="http://benedmunds.com/ion_auth/" target="_blank">IonAuth</a></li>
    <li><a href="https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html" target="_blank">AdminLTE</a></li>
    <li><a href="https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc" target="_blank">Modular Extensions</a></li>
</ul>
<h2><a href="#upgrading" id="upgrading">#</a> Upgrading</h2>
<p>Before performing an update you should take your site offline by replacing the index.php file with a static one.</p>
<ul>
    <li>Replace all files and directories in your <strong>system/</strong> directory.</li>
    <li>Replace all files and directories in your <strong>assets/</strong> directory.</li>
    <li>Replace all files and directories in your <strong>application/controllers/</strong> directory.</li>
    <li>Replace all files and directories in your <strong>application/libraries/</strong> directory.</li>
    <li>Replace all files and directories in your <strong>application/migrations/</strong> directory.</li>
    <li>Replace all files and directories in your <strong>application/modules/</strong> directory.</li>
    <li>Replace all files and directories in your <strong>application/third_party/</strong> directory.</li>
    <li>Replace all files and directories in your <strong>application/views/</strong> directory.</li>
</ul>
<div class="alert alert-warning">
    <strong><i class="fa fa-exclamation-circle"></i> Note</strong> <p>If you have any custom developed files in these directories, please make copies of them first.</p>
</div>
<h2><a href="#installation" id="installation">#</a> Installation</h2>
<ul>
    <li>Extract myIgniter.zip in your server</li>
    <li>Create Database</li>
    <li>Run myIgniter and follow step expert installation</li>
</ul>
<h2><a href="#config" id="config">#</a> Config</h2>
<h4>myignter</h4>
<p>Location : <strong>application/config/myigniter.php</strong></p>
<pre><code class="html">// Site
$config['site'] = [
    'title' => 'My Site', // Default Title entire page
    'favicon' => 'assets/img/favicon-96x96.png', // Default Favicon
    'logo' => 'assets/img/logo/myIgniter.png' // Default Logo
];

// Template
$config['template'] = [
    'front_template' => 'template/front_template', // Default front template
    'backend_template' => 'template/admin_template', // Default backend template
    'auth_template' => 'template/auth_template' // Default auth template
];

// Auth view
$config['view'] = [
    'login' => 'auth/login', // Default login view template
    'register' => 'auth/register', // Defaul register view template
    'forgot_password' => 'auth/forgot_password', // Default forgot password view template
    'reset_password' => 'auth/reset_password' // Default reset password view template
];

// Route
$config['route'] = [
    'default_page' => 'home', // Default first page route
    'login_success' => 'page/home' // Default redirect after success logedin
];

// Email Configuration
$config['email_config'] = [
    'protocol' => 'smtp',
    'smtp_host' => 'mail.kotaxdev.co',
    'smtp_user' => 'support@kotaxdev.co',
    'smtp_pass' => '',
    'smtp_port' => 587,
    'mailtype' => 'html',
    'charset' => 'iso-8859-1'
];

// social login
$config['facebook'] = [
    'appId' => '380835822278539',
    'secret' => '5b72d6329b48b310e29ca181d5af67f2',
    'access_token' => '380835822278539|4fFg48cQCDHotW74VgFvBzmTyyw',
    'fields' => 'id,name,email,first_name,last_name,birthday,about,gender,location,picture.type(large)'
];

$config['google'] = [
    'client_id' => '69371986177-fp39509a46252f15q6b7fm8i7o9uqog0.apps.googleusercontent.com',
    'client_secret' => 'UPHTYfG3KtCq2dF8VnZoXobT',
    'redirect_uri' => 'login',
];

$config['twitter'] = [
    'CONSUMER_KEY' => 'NeYOMXtjpxtuT7ZArTiplo5IL',
    'CONSUMER_SECRET' => '9Wba4B1Y5qES5jZLbRCgletrFi2u7HJ89HilIbXLIwY0yp70BO',
    'OAUTH_CALLBACK' => 'login',
];

$config['linkedin'] = [
    'appKey' => '86a9fuizxy35f1',
    'appSecret' => '4EcYeSTNzL5yz6zh',
    'callbackUrl' => 'login'
];

// default time zone
$config['timezone'] = 'Asia/Kolkata';

// skins setting 
# blue-light
# yellow
# yellow-light
# green 
# green-light   
# purple
# purple-light  
# red   
# red-light
# black
# black-light
$config['skin'] = 'red'; // selected skin

$config['google_recaptcha'] = [
    'site_key' => '6LeTSh8UAAAAAOXygATUlkTAFwdJuxecYZ8WzrwY',
    'secret_ket' => '6LeTSh8UAAAAAJTAP4jBsnHevXnPr13ThaZNmiur'
];

// optional features feel free to enable or disable this features in your web app
$config['features'] = [
    'google_recaptcha' => false,
    'login_via_facebook' => true,
    'login_via_google' => true,
    'login_via_twitter' => true,
    'login_via_linkedin' => true,
    'disable_all_social_logins' => false
];

// Debugbar
$config['debugbar'] = false; // True show debugbar
</code></pre>
<h2><a href="#library" id="library">#</a> Library</h2>
<h4><a href="#layout" id="layout">#</a> layout</h4>
<p>Location : <strong>application/libraries/layout.php</strong></p>
<pre><code class="html">set_title($title)
</code></pre>

    <ul>
        <li><strong>Parameter</strong>
            <ul>
                <li>$title(string) - Title of entire page</li>
            </ul>
        </li>
        <li><strong>Return type</strong>
            <ul>
                <li>Void</li>
            </ul>
        </li>
    </ul>
<pre><code class="html">get_title($tag = false)
</code></pre>

    <ul>
        <li><strong>Parameter</strong>
            <ul>
                <li>$tag(boolean) - true will output without tag &lt;title&gt;&lt;/title&gt; default false</li>
            </ul>
        </li>
        <li><strong>Return type</strong>
            <ul>
                <li>String</li>
            </ul>
        </li>
    </ul>
<pre><code class="html">get_logo()
</code></pre>

    <ul>
        <li><strong>Return type</strong>
            <ul>
                <li>Url</li>
            </ul>
        </li>
    </ul>
<pre><code class="html">get_favicon($favicon = null)
</code></pre>

    <ul>
        <li><strong>Parameter</strong>
            <ul>
                <li>$favicon(string) - url of favicon</li>
            </ul>
        </li>
        <li><strong>Return type</strong>
            <ul>
                <li>Favicon tag</li>
            </ul>
        </li>
    </ul>
<pre><code class="html">set_meta_tags($name, $content)
</code></pre>

    <ul>
        <li><strong>Parameter</strong>
            <ul>
                <li>$name(string) - tag name</li>
                <li>$conent(string) - content name</li>
            </ul>
        </li>
        <li><strong>Return type</strong>
            <ul>
                <li>Void</li>
            </ul>
        </li>
    </ul>
<pre><code class="html">get_meta_tags()
</code></pre>

    <ul>
        <li><strong>Return type</strong>
            <ul>
                <li>Meta tag</li>
            </ul>
        </li>
    </ul>
<pre><code class="html">set_schema($property, $content)
</code></pre>

    <ul>
        <li><strong>Parameter</strong>
            <ul>
                <li>$property(string) - property schema</li>
                <li>$conent(string) - content schema</li>
            </ul>
        </li>
        <li><strong>Return type</strong>
            <ul>
                <li>Void</li>
            </ul>
        </li>
    </ul>
<pre><code class="html">get_schema()
</code></pre>

    <ul>
        <li><strong>Return type</strong>
            <ul>
                <li>schema</li>
            </ul>
        </li>
    </ul>
<pre><code class="html">auth()
</code></pre>

    <ul>
        <li><strong>Return type</strong>
            <ul>
                <li>Redirect - if not logged in will redirect to login page</li>
            </ul>
        </li>
    </ul>
<pre><code class="html">set_privilege($group)
</code></pre>

    <ul>
        <li><strong>Parameter</strong>
            <ul>
                <li>$group(Integer) - id groups or groups name</li>
            </ul>
        </li>
        <li><strong>Return type</strong>
            <ul>
                <li>Redirect - if groups not exists redirect to login or home page</li>
            </ul>
        </li>
    </ul>
<pre><code class="html">setCacheAssets()
</code></pre>

    <ul>
        <li><strong>Return type</strong>
            <ul>
                <li>Void - Cache the assets (Minify css/js and save in cache assets)</li>
            </ul>
        </li>
    </ul>
<pre><code class="html">set_assets($path, $type)
</code></pre>

	<ul>
		<li><strong>Parameter</strong>
			<ul>
				<li>$path(String|Array) - url of assets js/css</li>
				<li>$type(String) - styles for css files, scripts for js files</li>
			</ul>
		</li>
		<li><strong>Return type</strong>
			<ul>
				<li>Void</li>
			</ul>
		</li>
	</ul>
<pre><code class="html">get_assets($type)
</code></pre>

	<ul>
		<li><strong>Parameter</strong>
			<ul>
				<li>$type(String) - styles for css files, scripts for js files</li>
			</ul>
		</li>
		<li><strong>Return type</strong>
			<ul>
				<li>String</li>
			</ul>
		</li>
	</ul>
<pre><code class="html">set_wrapper($view, $data = null,$name='page',$wrap_script = true)
</code></pre>

	<ul>
		<li><strong>Parameter</strong>
			<ul>
                <li>$view(String) - String url view partial page</li>
                <li>$data(String|Array) - Data parse to view partial page</li>
				<li>$name(String) - Name of wrapper</li>
				<li>$wrap_script(Boolean) - true move script in view page to bottom of body, default true</li>
			</ul>
		</li>
		<li><strong>Return type</strong>
			<ul>
				<li>Void</li>
			</ul>
		</li>
	</ul>
<pre><code class="html">get_wrapper($name)
</code></pre>

	<ul>
		<li><strong>Parameter</strong>
			<ul>
				<li>$name(String) - Name of wrapper</li>
			</ul>
		</li>
		<li><strong>Return type</strong>
			<ul>
				<li>View page</li>
			</ul>
		</li>
	</ul>
<pre><code class="html">render($template_name = 'front', $data = null)
</code></pre>

	<ul>
		<li><strong>Parameter</strong>
			<ul>
				<li>$template_name(String) - String template name view ('front','admin','auth') 
                    you can add templates as you wish in application/views/template.
                    just you must to name the file name like this (template_name + _template.php).
                    <br/>
                    selected template by default is 'front'
                    For Example: $this->layout->render(); // this will view front_template.php
                </li>
				<li>$data(String|Array) - Data parse to template page view</li>
			</ul>
		</li>
		<li><strong>Return type</strong>
			<ul>
				<li>View full page</li>
			</ul>
		</li>
	</ul>
<pre><code class="html">get_menu($type = 'side menu')
</code></pre>

	<ul>
		<li><strong>Parameter</strong>
			<ul>
				<li>$type(String) - Name of type menu default 'side menu'</li>
			</ul>
		</li>
		<li><strong>Return type</strong>
			<ul>
				<li>Array - list of menu</li>
			</ul>
		</li>
	</ul>
<pre><code class="html">breadcrumb($crumb, $homecrumb = null)
</code></pre>

	<ul>
		<li><strong>Parameter</strong>
			<ul>
				<li>$crumb(Array) - List of crumb menu</li>
				<li>$homecrumb(Array) - First breadcrumb default null</li>
			</ul>
		</li>
		<li><strong>Return type</strong>
			<ul>
				<li>String - List breadcrumb</li>
			</ul>
		</li>
	</ul>

<h4><a href="#logs" id="logs">#</a> Logs</h4>
<p>Location : <strong>application/models/logs.php</strong></p>
<pre><code class="html">addLogs($action, $logs)
</code></pre>

    <ul>
        <li><strong>Parameter</strong>
            <ul>
                <li>$action(String) - Action log</li>
                <li>$logs(Array) - List data log</li>
            </ul>
        </li>
        <li><strong>Return type</strong>
            <ul>
                <li>Integer - id log</li>
            </ul>
        </li>
    </ul>
<pre><code class="html">getLogs($id = null, $action = null, $limit = 10, $offset = 0)
</code></pre>

    <ul>
        <li><strong>Parameter</strong>
            <ul>
                <li>$id(Integer) - Id log</li>
                <li>$action(String) - Action Log</li>
                <li>$limit(Integer) - Limit</li>
                <li>$offset(Integer) - Offset</li>
            </ul>
        </li>
        <li><strong>Return type</strong>
            <ul>
                <li>Array - List logs</li>
            </ul>
        </li>
    </ul>

<br>
<h2><a href="#core" id="core">#</a> Core</h2>
<h4><a href="#my_model" id="my_model">#</a> MY_Model</h4>
<p>Location : <strong>application/core/MY_Model.php</strong></p>
<pre><code class="html">save($data, $tablename = '')
</code></pre>

	<ul>
		<li><strong>Parameter</strong>
			<ul>
				<li>$data(Array) - Data each field</li>
				<li>$tablename(String) - Table name default empty</li>
			</ul>
		</li>
		<li><strong>Return type</strong>
			<ul>
				<li>Integer - row affected</li>
			</ul>
		</li>
	</ul>
<pre><code class="html">search($conditions = null, $limit = 500, $offset = 0, $tablename = '')
</code></pre>

	<ul>
		<li><strong>Parameter</strong>
			<ul>
				<li>$conditions(String|Array) - Condition want to search</li>
				<li>$limit(Integer) - Number of limit default 500</li>
				<li>$offset(Integer) - Start offset default 0</li>
				<li>$tablename(String) - Table name default empty</li>
			</ul>
		</li>
		<li><strong>Return type</strong>
			<ul>
				<li>Array</li>
			</ul>
		</li>
	</ul>
<pre><code class="html">single($conditions, $tablename = '')
</code></pre>

	<ul>
		<li><strong>Parameter</strong>
			<ul>
				<li>$conditions(String|Array) - Condition want to show</li>
				<li>$tablename(String) - Table name default empty</li>
			</ul>
		</li>
		<li><strong>Return type</strong>
			<ul>
				<li>Array</li>
			</ul>
		</li>
	</ul>
<pre><code class="html">update($data, $conditions, $tablename = '')
</code></pre>

	<ul>
		<li><strong>Parameter</strong>
			<ul>
				<li>$data(String) - Field data want to change</li>
				<li>$conditions(String|Array) - Condition data want to update</li>
				<li>$tablename(String) - Table name default empty</li>
			</ul>
		</li>
		<li><strong>Return type</strong>
			<ul>
				<li>Integer - Affected rows</li>
			</ul>
		</li>
	</ul>
<pre><code class="html">delete($conditions, $tablename = '')
</code></pre>

	<ul>
		<li><strong>Parameter</strong>
			<ul>
				<li>$conditions(String|Array) - Condition data want to delete</li>
				<li>$tablename(String) - Table name default empty</li>
			</ul>
		</li>
		<li><strong>Return type</strong>
			<ul>
				<li>Integer - Affected rows</li>
			</ul>
		</li>
	</ul>
<pre><code class="html">count($conditions = null, $tablename = '')
</code></pre>

	<ul>
		<li><strong>Parameter</strong>
			<ul>
				<li>$conditions(String|Array) - Condition data want to count</li>
				<li>$tablename(String) - Table name default empty</li>
			</ul>
		</li>
		<li><strong>Return type</strong>
			<ul>
				<li>Integer - Number rows</li>
			</ul>
		</li>
	</ul>
<h2><a href="#examples" id="examples">#</a> Examples</h2>
<h4>Controllers</h4>
<pre><code class="html">&lt;?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Example Controller.
 */
class Example extends MX_Controller
{
    private $title;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('layout'); // Magic library

        $this->title = 'Hello World'; // Set title page
    }

    /**
     * Frontend Hello World page.
     */
    public function index()
    {
        $this->load->model('bookModel'); // Load smart model
        $data['book'] = $this->bookModel->search(); // Search model
        $data['helloWorld'] = 'Hello World'; // Data send to wrapper

        $this->layout->set_title($this->title);
        $this->layout->set_wrapper('hello_world', $data);
        $this->layout->render();
    }

    /**
     * Backend Hello World page.
     */
    public function backend()
    {
        $this->layout->auth(); // Login required

        $this->load->model('bookModel');
        $data['book'] = $this->bookModel->search();
        $data['helloWorld'] = 'Hello World';

        $template_data['title'] = 'Hellow World'; // Data send to template
        $template_data['crumb'] = [
            'Hellow World' => '',
        ];

        $this->layout->set_wrapper( 'hello_world', $data); // Set wrapper page
        $this->layout->render('admin', $template_data); // Output
    }

    /**
     * Backend CRUD Book Page.
     */
    public function crud()
    {
        $this->layout->auth(); // Login required

        $crud = new grocery_CRUD(); // Load library grocery CRUD

        $crud->set_table('book');
        $crud->set_subject('book');

        $data = (array) $crud->render();

        $template_data['grocery_css'] = $data['css_files'];
        $template_data['grocery_js'] = $data['js_files'];
        $template_data['title'] = 'CRUD';
        $template_data['crumb'] = [
            'CRUD' => '',
        ];

        $this->layout->set_wrapper('grocery', $data,'page',  false);
        $this->layout->render('admin', $template_data);
    }
}
</code></pre>

<h4>Model</h4>
<pre><code class="html">&lt;?php

defined('BASEPATH') or exit('No direct script access allowed');

class BookModel extends MY_Model
{
    public $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'book'; // Table name
    }
}
</code></pre>
<script>hljs.initHighlightingOnLoad();</script>

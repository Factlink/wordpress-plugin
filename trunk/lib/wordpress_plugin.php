<?php

namespace vg\wordpress_plugin;

// TODO: when rendering views access to methods like: form / input_field / .. creators
// TODO: add localization

class WordpressPlugin
{
    public $namespace = 'vg\wordpress_plugin';
    public $meta_prefix = '';

    public $root_path;
    public $app_path;
    public $lib_path;

    public $capability_path;
    public $model_path;
    public $view_path;

    public $capabilities;
    public $models;

    public $option_1;
    public $is_configured;

    public function __construct()
    {
        // wordpress hook for initiazing a plugin
        add_action('init', array($this, 'initialize'));
    }

    // does the actual plugin initialization
    public function initialize()
    {
        // setup the paths for the plugin
        $this->setup_paths();

        // load all the dependencies
        $this->load_dependencies();

        // check available models
        $this->store_available_models();

        // set activate / deactivate hooks
        $this->setup_global_plugin_hooks();

        // setup the hooks
        $this->setup_capabilities();
    }

    // stub method for setting up all the needed wordpress hooks
    protected function setup_capabilities()
    {
        throw new \Exception("WordpressPlugin: setup_capabilities() should be overridden.");
    }

    // add a capability on a wordpress trigger
    protected function add_capability($capability_name, $action_name = null, $wordpress_capabilities = null, $num_args = 1)
    {
        // TODO: validators should have arguments, like min/max length, etc

        // empty array means the current user always has enough rights
        $has_rights = true;

        // determine if the user has enough rights
        if ($wordpress_capabilities !== null) {
            for ($i = 0; $i < count($wordpress_capabilities); $i++) {
                if (current_user_can($wordpress_capabilities[$i]) === false) {
                    $has_rights = false;
                    break;
                }
            }
        }

        if ($has_rights) {
            // if the action is null, execute immediately
            if ($action_name === null) {
                $this->action_callback_handler($capability_name, array());
            } else {
                // when action is triggered run the anonymous function to instantiate the appropriate capability
                add_action($action_name, function () use ($capability_name) {
                    // get the function arguments
                    $args = func_get_args();

                    // call action callback handler when wordpress hook is called
                    $this->action_callback_handler($capability_name, $args);
                }, 10, $num_args);
            }
        }
    }

    // setup application paths
    protected function setup_paths()
    {
        $this->root_path = plugin_dir_path(__FILE__);
        $this->root_path = dirname($this->root_path) . "/";
        $this->app_path = $this->root_path . "app/";
        $this->lib_path = $this->root_path . "lib/";
        $this->capability_path = $this->app_path . "capability/";
        $this->model_path = $this->app_path . "model/";
        $this->view_path = $this->app_path . "view/";
    }

    // searches and stores the available models
    protected function store_available_models()
    {
        $this->models = array();

        // list all the models stored in the models directory
        if ($handle = opendir($this->model_path)) {

            while (false !== ($entry = readdir($handle))) {

                // skip the directory operators
                if ($entry !== '.' && $entry !== '..') {
                    $this->models[pathinfo($entry, PATHINFO_FILENAME)] = null;
                }
            }

            closedir($handle);
        }
    }

    // global wordpress plugin hooks for activation / deactivation / uninstall
    private function setup_global_plugin_hooks()
    {
        // generate the filename from the plugin class. So it's important the class is named the same as the file
        // TODO: check if the filename and the classname of the plugin are the same
        $file = \vg\wordpress_plugin\util\Util::from_camel_case(get_class($this)) . '.php';
        $file = $this->root_path . $file;

        // add wordpress activation hook
        register_activation_hook($file, array($this, 'activate_models'));

        // add a hook for when the plugin is deactivated
        register_deactivation_hook($file, array($this, 'deactivate_models'));

        // when plugin is uninstalled, call the uninstall method on all the models
        register_uninstall_hook($file, array($this, 'uninstall_models'));
    }

    // calls the activate method on all the models
    public function activate_models()
    {
        foreach ($this->models as $model_name => $model) {
            if ($model === null) {
                // get the model
                $model = $this->instantiate_model($model_name);
            }

            // run the activation method on the model
            $model->activate();
        }
    }

    // calls the deactivate method on all the models
    public function deactivate_models()
    {
        foreach ($this->models as $model_name => $model) {
            if ($model === null) {
                // get the model
                $model = $this->instantiate_model($model_name);
            }

            // run the activation method on the model
            $model->deactivate();
        }
    }

    // call the uninstall method on all the models
    public function uninstall_models()
    {
        foreach ($this->models as $model_name => $model) {
            if ($model === null) {
                // get the model
                $model = $this->instantiate_model($model_name);
            }

            // run the activation method on the model
            $model->uninstall();
        }
    }

    // load all the needed dependencies
    private function load_dependencies()
    {
        include("$this->lib_path/util/util.php");
        include("$this->lib_path/validator/validator.php");
        include("$this->lib_path/capability/capability.php");
        include("$this->lib_path/model/model.php");
        include("$this->lib_path/model/meta/meta.php");
        include("$this->lib_path/model/meta/option.php");
        include("$this->lib_path/model/meta/post.php");
    }

    // is called when registered wordpress action is called
    private function action_callback_handler($capability_name, $arguments)
    {
        if ($this->capabilities === null) {
            $this->capabilities = array();
        }

        // instantiate and store the capability
        $this->capabilities[$capability_name] = $this->instantiate_capability($capability_name, $arguments);
    }

    // create the capability
    private function instantiate_capability($capability_name, $arguments)
    {
        // TODO: only when capability is undefined?
        include "$this->capability_path" . "$capability_name.php";

        // get the class name of the capability from snake case
        $class_name = util\Util::to_camel_case($capability_name, true);
        $class_name = "$this->namespace\\capability\\" . $class_name;

        $plugin = $this;

        $capability = new $class_name($plugin, $capability_name);

        // check if the available models can be injected into the capability
        $this->inject_models($capability);

        // call the initialize method on the capability object with the arguments of the wordpress action
        call_user_func_array(array($capability, 'initialize'), $arguments);

        return $capability;
    }

    // inject models into the capability
    // TODO: should raise error when property is defined, but model doesn't exist
    private function inject_models($capability)
    {
        $class_name = get_class($capability);

        // check if any of the models has the same name as a property on a capability
        // if so, set the model on the capability
        foreach ($this->models as $model_name => $model) {

            if (property_exists($class_name, $model_name)) {

                if ($model === null) {

                    // TODO: should be moved to load_model
                    $this->models[$model_name] = $this->instantiate_model($model_name);

                    // update the local $model
                    $model = $this->models[$model_name];
                }

                // using {} to dynamically set a property on an object
                $capability->{$model_name} = $model;
            }
        }
    }

    // load and create a model
    // TODO: refactor, so instantiate model and capability don't use the same code
    private function instantiate_model($model_name)
    {
        include "$this->model_path" . "$model_name.php";

        // get the class name of the capability from snake case
        $class_name = util\Util::to_camel_case($model_name, true);
        $class_name = "$this->namespace\\model\\" . $class_name;

        $model = new $class_name();

        $model->plugin = $this;
        $model->meta_prefix = $this->meta_prefix;
        $model->initialize();

        return $model;
    }

    // TODO: refactor, so instantiate model and capability don't use the same code
    public function instantiate_validator($validator_name)
    {
        // include the model
        include "$this->lib_path" . "validator/$validator_name.php";

        // get the class name of the capability from snake case
        $class_name = util\Util::to_camel_case($validator_name, true);
        $class_name = "vg\\wordpress_plugin\\validator\\" . $class_name;

        $validator = new $class_name();

        return $validator;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: maarten
 * Date: 24/03/14
 * Time: 09:50
 */

namespace vg\wordpress_plugin;

class WordpressPlugin
{
    public $namespace = 'vg\wordpress_plugin';

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
        // setup the paths for the plugin
        $this->setup_paths();

        // load all the dependencies
        $this->load_dependencies();

        // check available models
        $this->store_available_models();

        // setup the hooks
        $this->setup_capabilities();
    }

    // set all the needed wordpress hooks
    protected function setup_capabilities()
    {
        //
        throw new \Exception("WordpressPlugin: setup_capabilities() should be overridden.");
    }

    // add a capability on a wordpress trigger
    protected function add_capability($capability_name, $action_name)
    {
        // TODO: check here whether capabilities will be instantiated at all, based on the wordpress capabilities

        // when action is triggered run the anonymous function to instantiate the appropriate capability
        add_action($action_name, function() use ($capability_name)
        {
            $this->action_callback_handler($capability_name, func_get_args());
        });
    }

    // setup application paths
    protected function setup_paths()
    {
        // setup the root path
        $this->root_path = plugin_dir_path( __FILE__ );

        // remove the directory of the path and add a trailing slash
        $this->root_path = dirname($this->root_path) . "/";

        // setup the application path
        $this->app_path = $this->root_path . "app/";

        // setup lib path
        $this->lib_path = $this->root_path . "lib/";

        // setup capability path
        $this->capability_path = $this->app_path . "capability/";

        // setup model path
        $this->model_path = $this->app_path . "model/";

        // setup the view path
        $this->view_path = $this->app_path . "view/";
    }

    // searches and stores the available models
    protected function store_available_models()
    {
        // instantiate the models array
        $this->models = [];

        // list all
        if ($handle = opendir($this->model_path)) {

            // loop over the directory
            while (false !== ($entry = readdir($handle))) {

                // skip the directory operators
                if ($entry !== '.' && $entry !== '..')
                {
                    $this->models[pathinfo($entry, PATHINFO_FILENAME)] = null;
                }

            }

            // close the directory handle
            closedir($handle);
        }
    }

    // load all the needed dependencies
    private function load_dependencies()
    {
        // load the utils
        include ("$this->lib_path/util/util.php");

        // load the validators
        include ("$this->lib_path/validator/validator.php");

        // load the capability
        include ("$this->lib_path/capability/capability.php");

        // load the model
        include ("$this->lib_path/model/model.php");

        // load the model
        include ("$this->lib_path/model/option.php");
    }

    // is called when registered wordpress action is called
    private function action_callback_handler($capability_name, $arguments)
    {
        // if the capabilities array isn't instantiated, instantiate
        if ($this->capabilities === null)
        {
            $this->capabilities = [];
        }

        // instantiate and store the capability
        $this->capabilities[$capability_name] = $this->instantiate_capability($capability_name, $arguments);
    }

    // create the capability
    private function instantiate_capability($capability_name, $arguments)
    {
        // load the capability
        // TODO: only when capability is undefined?
        include "$this->capability_path" . "$capability_name.php";

        // get the class name of the capability
        $class_name = util\Util::to_camel_case($capability_name, true);

        // add the namespace
        $class_name = "$this->namespace\\capability\\" . $class_name;

        // get the appropriate plugin
        $plugin = $this;

        // create a new capability
        $capability = new $class_name($plugin, $capability_name);

        // check if the available models can be injected
        $this->inject_models($capability);

        // call the initialize method on the capability object with the arguments of the wordpress action
        call_user_func_array(array($capability, 'initialize'), $arguments);

        // return the capability
        return $capability;
    }

    // inject models into the capability
    // TODO: should raise error when property is defined, but model doesn't exist
    private function inject_models($capability)
    {
        // get the instance class
        $class = get_class($capability);

        // iterate all the models
        foreach ($this->models as $model_name => $model)
        {
            // if the property exists on the capability
            if (property_exists($class, $model_name))
            {
                // check if the model is already loaded
                if ($model === null)
                {
                    // instantiate and store the new model
                    $this->models[$model_name] = $this->instantiate_model($model_name);

                    // update the local $model
                    $model = $this->models[$model_name];
                }

                // inject the model
                $capability->{$model_name} = $model;
            }
        }
    }

    // load and create a model
    // TODO: refactor, so instantiate model and capability don't use the same code
    private function instantiate_model($model_name)
    {
        // include the model
        include "$this->model_path" . "$model_name.php";

        // get the class name of the capability
        $class_name = util\Util::to_camel_case($model_name, true);

        // add the namespace
        $class_name = "$this->namespace\\model\\" . $class_name;

        // instantiate the actual model
        $model = new $class_name();

        // return the newly created model
        return $model;
    }

}
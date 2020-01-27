<?php
namespace WPMVC\Views;

use WPMVC\Core\Request\Request;

class ViewLoader{

    private $templ_dir;
    private $view;
    private $vars=[];
    private $request;
    private $hasWPHeader=true;
    private $hasWPFooter=true;

    /**
     * New View Instance
     * @param String $viewName
     * @return $this
     */
    public function __construct(String $viewName){
        $this->templ_dir = get_stylesheet_directory()."/inc/Views/";
        $this->view=$this->templ_dir.$this->__parse_view_name($viewName).".php";
        return $this;
    }

    /**
     * Add attributes to view
     * @param Array $attrs
     * @param String <$value>
     * @return ViewLoader
     */
    public function with(Array $attrs, String $value = ""){
        $this->vars=array_merge($this->vars, $attrs);
        return $this;
    }
    
    /**
     * Set an attribute
     * @param String $attrName
     * @param Mixed $value
     * @return ViewLoader
     */
    public function set(String $attrName, Mixed $value){
        $this->vars[$attrName] = $value;
        return $this;
    }

    /**
     * Get an attribute
     * @param String $attrName
     * @return Mixed
     */
    public function get(String $attrName){
        return $this->vars[$attrName];
    }

    /**
     * Get Request Object
     * @return Request 
     */
    public function request(){
        return $this->request;
    }

    /**
     * Print function with escaping of html
     * @param $string
     * @return String
     */
    public function print($input){
        if(\is_array($input)){
            $d=\json_encode($input, JSON_PRETTY_PRINT);
        }else{
            $d = \htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        }
        echo $d;
    }

    /**
     * Turn off Wordpress Header
     * @return ViewLoader
     */
    public function noWPHeader(){
        $this->hasWPHeader=false;
        return $this;
    }
    /**
     * Turn off Wordpress Footer
     * @return ViewLoader
     */
    public function noWPFooter(){
        $this->hasWPFooter=false;
        return $this;
    }

    /**
     * Render view
     * @return ViewLoader
     */
    public function __render(Request $request){
        $this->request = $request;
        if(!file_exists($this->view)){
            throw new \Exception('No template file found at ' . $this->view);
            return $this;
        }

        ob_start();
        if($this->hasWPHeader){ get_header(); }
        include_once($this->view);    
        if($this->hasWPFooter){ get_footer(); }               
        ob_flush();

        return $this;
    }

    /**
     * Parse View names
     * @param String $name
     * @return String
     */
    private function __parse_view_name(String $name){
        return str_replace(".", "/", $name);
    }

    /**
     * Load Include
     * @param String $fileName
     * @return String
     */
    public function include(String $fileName){
        $fileName .=".php";
        if(!file_exists($this->templ_dir.$fileName)){
            throw new \Exception('No template file found at ' . $this->templ_dir.$fileName);
            return $this;
        }
        include($this->templ_dir.$fileName);   
    }

    /**
     * Get HTML of view
     * @return String
     */
    public function __html(){
        $this->request = $request;
        if(!file_exists($this->view)){
            throw new \Exception('No template file found at ' . $this->view);
            return $this;
        }

        ob_start();
        include_once($this->view);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}


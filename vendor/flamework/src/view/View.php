<?php
namespace support\view;

class View
{
    static function viewFinder($name){
        $names = explode(".", $name);
        $indexes = count($names); 
        $location = "";
        for ($i = 0; $i < $indexes - 1; $i++) {
            $location .= $names[$i] . "/";
        }
        return  $location . end($names) . ".php";
    }

    static function viewComposer($viewLocation,$dataBundleToViewer){
        $view = new viewComposer($viewLocation,$dataBundleToViewer);
        $view->view();
    }

    
}

class ViewComposer
{
    public $data;
    public $view;

    public function __construct($viewLocation,$dataBundleToViewer)
    {
        $this->data = $dataBundleToViewer;
        $this->view = $viewLocation;
    }

    public function view()
    {
        if(is_array($this->data)){  
            extract($this->data);
        }
        $data = $this->data;
        return include_once(PROJECT_ROOT."/resources/views/" . $this->view);
    }
    
}

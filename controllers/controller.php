<?php
//include_once "/models/parcer_PHPNET.php";
//include_once "/templates/parcer_PHPNET.php";


class controller
{
    private $model, $template, $template_name;

    public function __construct()
    {
        return true;
    }

    function setData($name){
        $this->template_name=$name;
        $this->model=$this->getModel($name);
        $this->template=$this->getTemplate($name);
    }

    function getModel($name){
        $file_name="parcer_".$name.".php";
        $path =$_SERVER['DOCUMENT_ROOT']."/models/".$file_name;
        $model_name="parcer_".$name;
        if (file_exists($path)) {
            require_once $path;
            $model=new $model_name();
        } else {
            throw new Exception("Модель <strong>$path</strong> не найден");
        }
        return $model;
    }

    function getTemplate(){
        $file_name="parcer_".$this->template_name.".php";
        $path =$_SERVER['DOCUMENT_ROOT']."/templates/".$file_name;

        if (file_exists($path)) {
            $data=$this->model->getData(ARRRSSURL[$this->template_name]);
            ob_start();
            require $path;
            $template= ob_get_clean();
        } else {
            throw new Exception("Шаблон <strong>$this->template_name</strong> не найден");
        }

        return $template;
    }


}
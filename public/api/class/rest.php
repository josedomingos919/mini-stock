<?php
    
    include_once 'application.php';
    include_once 'auxiliary.php';
    include_once 'generic.php';
    include_once 'file.php';
    include_once 'batabase.php';


    class Rest extends Aux {

        public function inicialize(){

            $r      = $_REQUEST;   
            $url    = explode('/', $r['url']);
            $class  = null;
            $method = null;

            if(!isset($url[0])){
                $this -> showErro(2);
                return;
            }
            elseif(empty(trim($url[0]))){
                $this -> showErro(2);
                return;
            }
            else{

                $class    = $url[0];
                $not_call = array('generic'=>null,'database'=>null,'upload'=>null);
                
                if(array_key_exists($class, $not_call)){
                    echo json_encode(array("info"=>"Class [ ".$class." ] Não pode ser acessada!!"));
                    return;
                }

                if(file_exists("./class/$class.php")){
                    include_once "$class.php";
                    if(!class_exists($class)){
                        $this->showErro(2);
                        return;
                    }
                }else{
                    $this->showErro("Rota não existe!");
                    return;
                }

            }
            
            if(!isset($url[1])){    
                $this->showErro(1);
                return;
            }
            elseif(empty(trim($url[1]))){
                $this->showErro(1);
                return;
            }
            else{
                $method = $url[1];
                if(!method_exists($class,$method)){
                    $this->showErro(3);
                    return;
                }
            }

            $_REQUEST['class']   =  $class;
            $_REQUEST['method']  =  $method;
            $_REQUEST["unlink"]  =  isset($_REQUEST["unlink"]) ? $_REQUEST["unlink"] : false;

            $data  =  [];
            $obj   =  array(new $class,$method);
            $vetFilesNames =  $this->startUpload();


            foreach($_REQUEST as $key=>$value){
                $data [$key] = $value;
            }
            
            foreach($vetFilesNames as $key=>$value){
                $data[$key] = $value;
            }

            unset($data['class']);
            unset($data['method']);
            unset($data['url']);
            unset($data["unlink"]);

            call_user_func_array($obj,[$data]); 
            
    }
}

?>

<?php

    class usuario extends Generic {

        
        public function add($data){
            $c = new Cript();
            $senha =  $data["senha"];
            $senha = $c->encode($senha);
            $data["senha"] = $senha;
            unset($data["confirm"]);
            
            $g = new Generic();
            $res = $g->add($data);
        }

        public function startEdit ($data){
            unset($data["senha"]);
            unset($data["confirm"]);
            $g = new Generic();
            $res = $g->edit($data);
        }

        public function edit($data){

            $isForget = false;
            if(isset($_REQUEST["forget"])){
                $isForget = true;
                unset($data["forget"]);
            }

      
            if(!isset($data["id"])) {
                $this->showErro("Id não foi Passado!");
                exit;
            }else{
                if(empty($data["id"])){
                    $this->showErro("Id não foi Passado!");
                    exit;
                }
            }  

            if(isset($data["confirm"]) || $isForget){
               
                if(empty($data["confirm"]) && !$isForget){
                   $this->startEdit($data);
                } else{

                    if(!isset($data["senha"])){
                        $this->showErro("Esperava a nova senha!");
                        exit;
                    }else{
                        if(empty($data["senha"])){
                            $this->showErro("Esperava a nova senha!");
                            exit;
                        }
                    }

                    $db        =  new Database();
                    $cn        =  $db->getter_getConnection();
                    $id  =  mysqli_real_escape_string($cn,  $data["id"]);
                    
                    mysqli_close($cn);
                    
                    $res     =  $db->query("select *from usuario where id = $id ;");
                     
              
                    $linhas = 0;
                    if($res["status"] === true)
                    $linhas  =  $res['data']->num_rows;
        
                
                    if($linhas == 0){
                        echo json_encode(["status"=>false, 'sms'=>"Usuário não existe","cod"=>20]);
                        exit;
                    }

        
                    $rest = new Rest();
                    $dataArray  = $rest->dataArray($res)[0];
                    $passwordIn = "".$this->decode(($dataArray)['senha']);
                
                    if( $isForget || $passwordIn === $data["confirm"] ){

                        $c = new Cript();
                        $g = new Generic();

                        unset($data["confirm"]);
                        $senha = $data["senha"];
                        $data["senha"] = $c->encode($senha);
                        $_REQUEST["notSacape"] = ["senha"];
                        $res = $g->edit($data);

                    }else{ 
                        echo json_encode(["status"=>false, 'sms'=>"Senha incorrecta!","cod"=>21]);
                    }
                }
            }else{
                $this-> startEdit($data);
            }

        }
        
    }

?>
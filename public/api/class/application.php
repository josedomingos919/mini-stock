<?php

    include_once 'auxiliary.php';
    include_once 'emailService.php';

    class Application extends Aux{

        public $returnEmail = false;

        public function login($_DATA){

            if(!(isset($_DATA['username']) && isset($_DATA['password']))){
                echo json_encode(['info'=>'Esperava receber nome de usuário e senha!','data'=>null,'status'=>false]);
                return;
            }

            $db        =  new Database();
            $cn        =  $db->getter_getConnection();
            $userName  =  mysqli_real_escape_string($cn, $_DATA['username']);
            $password  =  mysqli_real_escape_string($cn, $_DATA['password']);
            
            mysqli_close($cn);
            
            $res     =  $db->query("select *from usuario where email = '$userName' ");
            $linhas  =  $res['data']->num_rows;

            if($linhas == 0){
                $this->showErro('Usuário não existe');
                exit;
            }

            $rest = new Rest();
            $dataArray  = $rest->dataArray($res)[0];

            $passwordIn = "".$this->decode(($dataArray)['senha']);

            if($passwordIn !== $password){
                $this->showErro('Senha Errada!');
                exit;
            }

            $this->echoResult(true,"Login feito com sucesso!",$dataArray,[],[]);
        }
        
        public function sendEmail($_DATA){
            $empty = [];
            $missed = [];
            $invalid = [];
            $status = true;

            foreach(["from","fromName","to","toName","subject","body"] as $key){
                if(array_key_exists($key,$_DATA)){
                 
                    if(empty($_DATA[$key])){
                    array_push($empty, $key);
                    $status = false;
                  }elseif ($key === "from" || $key === "to"){
                     
                    if (!filter_var($_DATA[$key], FILTER_VALIDATE_EMAIL)) {
                        array_push($invalid, ["campo"=>$key,"value"=>$_DATA[$key]]);
                        $status = false;
                    }
                 }
                }else{
                    $info = "missed field '$key' ,";
                    array_push($missed, $key);
                    $status = false;
                }
            }

            $res = ["status"=>$status,"empty"=> $empty, "missed"=>$missed,  "invalid"=>$invalid ];
            if(!$status){
                echo json_encode($res);
                return;
            }

            $email = new Email();
            $res = $email->send($_DATA);

            if(!$this->returnEmail){
                echo json_encode($res);
            }
            else {
                return $res;
            }
        }

        public function logout(){
            if(isset($_COOKIE['user'])){
                var_dump((array)json_decode($_COOKIE['user']));
            }else{
                var_dump("deslogado");
                //gerar tolkin
            }
        }

        public function deleteLink($data){

            $id_email = null;
            if(isset($data["id_email"])){
                $id_email  = $data["id_email"];
            }
 
            $db     =  new Database();  
            $cn     =  $db->getter_getConnection();
            $rest   =  new Rest();
            
            $query_text  = "  duracao > 5  ";
            if($id_email){
                $id_email =  mysqli_real_escape_string($cn, $id_email ); 
                $query_text = " email = '$id_email' ";
            } 
            
            $data = $db->query("select fileName, fullname from vwLinkpassword where $query_text ;");
            $data = $rest->dataArray($data);
            
            foreach($data as $item ){
                if(file_exists($item["fileName"])){
                    unlink($item["fullname"] );
                }
            }

          $data = $db->query("delete from vwLinkpassword where $query_text ;");
        }
        
        public function resetPassword($_DATA){
         
            $this->deleteLink($_DATA);
 
            if(!(isset($_DATA['email']))){
                echo json_encode(['info'=>'Esperava receber um email','data'=>null,'status'=>false]);
                exit;
            }
 
            $db        =  new Database();
            $cn        =  $db->getter_getConnection();
            $email  =  mysqli_real_escape_string($cn, $_DATA['email']); 
            
            mysqli_close($cn);
            
            $res     =  $db->query("select * from usuario where email = '$email' ");
            $linhas  =  $res['data']->num_rows;

            if($linhas == 0){
                $this->showErro('Email não encontrado!');
                exit;
            }
            
            

            $db->query("delete from linkPassword where email = '$email' ");
             
            $rest = new Rest();
            $dataArray  = $rest->dataArray($res)[0];
            $fileName = "./ResetPassword/".$dataArray["id"].".php";
            $name = $dataArray["id"].".php";

            $link = "./ResetPassword/example.txt";
            $example = fopen($link,"r");
            $content = fread($example,filesize($link));
            fclose($example);
          
         
            $txt = " <?php  $"."email"." = '$email'; ?> ";
            $myfile = fopen($fileName ,"w");
            fwrite($myfile,$txt.$content);

            fclose($myfile);

            $fullName = $_SERVER['DOCUMENT_ROOT']."/Unibega/api/ResetPassword/$name";  

            $db->query(" insert into linkPassword values (default, '$fileName ','$fullName', '$email', default); ");

            $link = "http://localhost/unibega/api/ResetPassword/$name";
 
            $this->returnEmail=true;
            $res =  $this->sendEmail(
                [
                    
                    "from"=>"nascimentomanuel09@gmail.com",
                    "fromName"=>"Unibega",
                    "to"=> $_DATA['email'],
                    "toName"=> $_DATA['email'],
                    "subject"=> "UNIBEGA, link para fazer a redefinição da sua senha!...",
                    "body"=>"
                    link:  
                         <a target='blunk' href='$link'> Click Aqui</a>
                    ",
                ]
            );
            
            $dataArray["infoEmail"] = $res;    
            $this->echoResult(true,"link de redefinição de senha enviado com sucesso!",$dataArray,[],[]);
        }
    }
?>


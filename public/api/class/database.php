<?php

     class Database extends File{

        private $localhost     =  "localhost";
        private $user          =  "root";
        private $password      =  "";
        private $database      =  "miniStock";
        private $tableNow      =  null;
        private $connection    =  null;
        public static $isPage  =  0;

        public function getDesc($table){
         
            $res    =  $this->execNonQuery("desc $table");
            $array  =  array();
            
            while($row =  mysqli_fetch_array($res['data'])){
                array_push($array,$row);
            }
            return $array;
        }

        public function totalRegister($table){
            $res  =  $this->execNonQuery("select count(*) from $table");
            $row  =  mysqli_fetch_array($res['data']);
            return $row[0];
        }

        private function getConnection (){
            $cn   =  mysqli_connect($this->localhost,$this->user,$this->password,$this->database);
            $cn  ->  set_charset('utf8mb4');
            return $cn;
        }

        public function getter_getConnection(){
            $cn = $this->getConnection();
            return $cn;
        }
        
        private function execNonQuery($cmdTxt){
            
            if($this->getConnection()){
                
                $cn       =  $this->getConnection();
                $result   =  null;
                $total    =  0;
                $table    =  $this->tableNow;
                $erro     =  null;
                $last_id  =  0;

                try {

                    $result   =  $cn->query($cmdTxt);
                    $erro     =  mysqli_error_list($cn);
                    $erro     =  !empty($erro) ? $erro[0] : $erro;
                    $last_id  =  $cn->insert_id;
                    
                    if(!empty($table)){
                        $total = mysqli_fetch_array($cn->query("select count(*) from $table"))[0];
                    }

                }
                catch (Exception $e){
                    echo($e->getMessage());
                }

                $status          =  $result ? true : false;
                $data            =  $result;
                $linhas          =  is_object($result)?  $data->num_rows  : 0;
                $this->tableNow  =  null;

                $upload  =  $status ? $this->uploadAll() : null;
                $unlink  =  $status && $_REQUEST["unlink"] !== false ? $this->deletFiles($_REQUEST["unlink"]) : 0;

                mysqli_close($cn);
                return  [
                    'status'       =>  $status,
                    'data'         =>  $data,
                    'all'          =>  $total,
                    'line'         =>  $linhas,
                    'query'        =>  $cmdTxt,
                    'error'        =>  $erro,
                    'inserted_id'  =>  $last_id,
                    'upload'       =>  $upload,
                    'unlink'       =>  $unlink
                    ];
            }else{
                return null;
            }
        }

        public function add($table_name,$data){

            $values = "";
            $keys   = "";
            $cn     = $this->getConnection();

            
            if(!$cn) return null;

            

            $this->tableNow = $table_name;

            foreach (array_keys($data) as $key){

                $valor  =  $data[$key];
                $tipo   =  gettype($valor);
                ($tipo == 'NULL') ? $values.=  $tipo.","  : $values.= "'".mysqli_real_escape_string($cn,$valor)."',";
                $keys  .= $key.",";  
            }

           // echo json_encode ($values);
           // return;


            mysqli_close($cn);

            $values  =  substr($values,0, strlen($values)-1);
            $keys    =  substr($keys,0,strlen($keys)-1);
            $query   = "insert into ".$table_name."(".$keys.") values(".$values.")";
            
            return $this->execNonQuery($query);
        }

        public function queryT($query,$table){
            $this->tableNow = $table;
            return $this->execNonQuery($query);
        }

        public function query($query){
            return $this->execNonQuery($query);
        }

        public function remove($table,$id){
            
            $vet    =  explode(',',$id);
            $query  =  "";
            $count  =  0;

            foreach($vet as $value){
                if(!empty($value)){
                    if($count == 0){
                        $count++;
                        $query .= "delete from $table where id=$value";
                    }else{
                        $query .= "or id = $value ";
                    }
                }
            }

            return $this->execNonQuery($query);
        }

        public function edit($id,$table_name,$data){
    
            $cn = $this->getConnection();

            if(!$cn) return null;

            $this->tableNow = $table_name;
            $field  = "";

          
            foreach ($data as $key=>$value){

                $tipo    =   gettype($value);
                $value   =   $tipo == 'NULL' ? $tipo."," : "'".mysqli_real_escape_string($cn,$value)."',";
                $field  .="  $key = $value";
               
            }

            $field = substr(trim($field), 0, strlen(trim($field))-1);
            mysqli_close($cn);
            $query = "update $table_name set $field where id='$id'";
            
            return $this->execNonQuery($query);
        }

    }

?>
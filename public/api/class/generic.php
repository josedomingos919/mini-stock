<?php

    class Generic extends Aux {

        public function delete_all($valor){
            $table_name  =  $_REQUEST['class'];
            $rest        =  new Rest();
            $db          =  new Database();
            $res         =  $db->queryT(" truncate $table_name ;",$table_name);
            echo json_encode($res);
        }

        public function remove($valor){
            $table_name  =  $_REQUEST['class'];
            $rest        =  new Rest();
            $db          =  new Database();
            $id          =  isset($_REQUEST['id']) 
            ? 
                empty(trim($_REQUEST['id'])) 
                ? null
                : trim($_REQUEST['id'])
            : null;

            if(!$id){
                $this->showErro("Esperava um id válido!!");   
                return;
            }
            $res         =  $db->remove($table_name,$id);
            echo json_encode($res);
        }
        
        private function graphArray($data){

            $result = [];

            foreach($data as $item){
                $v1 = [];
                foreach(array_keys($item) as $key){
                    $aux = explode("__", $key);

                    if(count($aux) == 2){
                        $v1[strtolower($aux[0])][$aux[1]] = $item[$key];
                    }else{
                        $v1[$aux[0]] = $item[$key];
                    }
                }

                $result[] = $v1;
            }

            return $result;
        }

        public function all($d){

            $table_name = $_REQUEST['class'];

            if(!isset($_REQUEST['limit'])) $_REQUEST['limit']  =  5;
            if(!isset($_REQUEST['page' ])) $_REQUEST['page' ]  =  1;
            
            $isOrder = false;
            if(isset($_REQUEST['order']) ){
                if(!empty(trim($_REQUEST['order']))){
                    $isOrder = true;
                }
            }

            $isCont = false;
            if(isset($_REQUEST['cont']) ){
                if(!empty(trim($_REQUEST['cont']))){
                    $isCont = true;
                }
            }
            

            $leftJoin = false;
            if(isset($_REQUEST['leftJoin'])){
                if(trim($_REQUEST['leftJoin']) == "true"){
                    $leftJoin = true;
                }
            }
            
            $isGraph = false;
            if(isset($_REQUEST['graph'])){
                if(trim($_REQUEST['graph']) == "true") {
                    $isGraph = true;
                }
            }

            $isJoin = false;
            if(isset($_REQUEST['isJoin'])){
                if(trim($_REQUEST['isJoin']) !== "") {
                    $isJoin= true;
                }
            }

            $isAllPage = false;
            if(isset($_REQUEST['allPage'])){
                if(trim($_REQUEST['allPage'])=="true") $isAllPage = true; 
            }

            $isMoreTable = false;
            if(isset($_REQUEST['moreTable'])){
                if(trim($_REQUEST['moreTable']) !== "") {
                    $isMoreTable = true;
                }
            }

            $isSubquary = false;
            if(isset($_REQUEST['subQuary'])){
                if(!empty(trim($_REQUEST['subQuary']))) {
                    $isSubquary = true;
                }
            }


            $isWhere = isset($_REQUEST['where']) ? ( !empty($_REQUEST['where']) ? true : false )  : false;
            
            $rest       =  new Rest(); 
            $db         =  new Database();
            $join       =  "";
            $fields     =  "";
            $tables     =  "";
            $condicoes  =  "";
            
            if(isset($_REQUEST['isJoin'])){

                $valor = trim($_REQUEST['isJoin']);
            
                if(!empty($valor) && $valor == "true" || !empty($valor) && $valor == "all" ) {
                    
                $rest_tb        =  $db->getDesc($table_name);
                $res_all        =  [];
                $resTb          =  $table_name;
                $table_name_    =  $table_name;
                $crt            =  0;

                if($valor == "true"){
                    
                    foreach($rest_tb as $item){

                        $campo =  $item['Field'];
                        $field = explode('_', $campo);
                    
                        if(key_exists(1,$field) && trim($field[0]) == 'id'){
                            
                            $tb          =  $field[1];
                            $tables     .=  "$tb ,";
                            $join       .= ($leftJoin ? 'left' : '')." join $tb on  $tb.id = $table_name.$campo ";
                            $condicoes  .=  " and $tb.id = $table_name.$campo ";
                            $tbCampo     =  $db->getDesc($tb);
                            
                            foreach($tbCampo as $e){
                                $cmp     =  $e['Field'];
                                $sep     =  $isGraph  ? '__' : "_";
                                $fields .=  "$tb.$cmp as ".strtoupper($tb).$sep.$cmp.", ";
                            } 
                        }
                    }

                }else{
        
                    while($crt == 0){
                        foreach($rest_tb as $item){

                            $campo =  $item['Field'];
                            $field = explode('_', $campo);
                        
                            if(key_exists(1,$field) && trim($field[0]) == 'id'){
                                
                                $tb              =  $field[1];
                                $tables         .=  "$tb ,";
                                $res_all[$tb]    =  $tb;
                                $join           .=  "join $tb on  $tb.id = $table_name_.$campo ";
                                $condicoes      .=  " and $tb.id = $table_name_.$campo ";
                                $tbCampo         =  $db->getDesc($tb);
                                
                                foreach($tbCampo as $e){
                                    $cmp = $e['Field'];
                                    $sep = $isGraph  ? '__' : "_";
                                    $fields.= "$tb.$cmp as ".strtoupper($tb).$sep.$cmp.", ";
                                }
                            }
                        }
                    
                        if(count($res_all) > 0){
                        
                            $valor       =  array_values($res_all)[0];
                            $rest_tb     =  $db->getDesc($valor);
                            $table_name_ =  $valor;

                            unset($res_all[$valor]);
                        }else{
                            $crt = 1;
                        };
                    }
                }

                }
            }

            if(isset($_REQUEST['moreTable'])){
                    
                $more = explode(',',trim($_REQUEST['moreTable']));
                
                if(!empty($_REQUEST['moreTable'])){
                    foreach($more as $item){
                        if(!empty($item)){
                            
                            $vetTb       =  explode(' ',trim($item));
                            
                            $q1          =  trim($vetTb[0]);
                            $vetExp      =  explode('.',trim($q1));
                            $tb1         =  $vetExp[0];
                            $q11         =  $vetExp[0].'.'.$vetExp[1]; 

                            $alias       =  count($vetExp) == 3 ? $vetExp[2] : null;

                            $q2          =  trim($vetTb[1]);
                            $tb2         =  explode('.',trim($q1))[0];
                            $per         =  $leftJoin ? 'left' : '';
                            $tables     .=  "$tb1 ,";

                            $join       .=  $alias==null ? " $per join $tb1 on  $q11 = $q2 " : " $per join $tb1 as $alias on $alias.".$vetExp[1]." = $q2 ";

                            $condicoes  .=  " and $q1 = $q2 ";
                            $tbCampo     =  $db->getDesc($tb1);
                        
                            foreach($tbCampo as $e){
                                $cmp     =  $e['Field'];
                                $sep     =  $isGraph ? '__' : "_";
                                $fields .=  $alias==null? "$tb1.$cmp as ".strtoupper($tb1).$sep.$cmp.", " :  "$alias.$cmp as ".strtoupper($alias).$sep.$cmp.", " ;
                            }
                        }
                    }
                }
            }

            //return;

            if($isJoin == true ||  $isMoreTable == true ){
                $tables = substr($tables,0,(strlen($tables)-1));
                $fields = trim($fields);
                $fields = substr($fields,0,(strlen($fields)-1));
            }
            
         

            if(isset($_REQUEST['field'])){

                $field = $_REQUEST['field'];
                if(!empty($field))
                $query  = "select $field from $table_name";
                $fields = $field;
            }

            
            if(isset($_REQUEST['subQuary'])){

                $unir = $_REQUEST['subQuary'];
                if(!empty($unir)){

                    $vet_unir = explode(',',$unir);

                    foreach($vet_unir as $i){

                        $vet_result_  = explode(' ',$i);
                        
                        if(count($vet_result_)==5){
                            
                            $tb     =  $vet_result_[0];
                            $tb_id  =  $tb.".".$vet_result_[1];
                            $tb_id2 =  $vet_result_[2].".".$vet_result_[3];
                            $alias  =  $vet_result_[4];
                            $data   =  $db->getDesc($tb);

                            //$fields = $fields != "" ? ", " : $fields;
                            if(!empty($join)) $fields .=",";

                            foreach($data as $line){
                                $campo    =   $line['Field'];
                                $sep      =   $isGraph  ? '__' : "_";
                                $fields  .=   " (select $tb.$campo from $tb where $tb_id = $tb_id2 limit 1) as _".strtoupper($alias.'_'.$tb).$sep.$campo.", ";
                            }
                        }
                    }

                    //return;

                    $fields = trim($fields);
                    $fields = substr($fields,0,(strlen($fields)-1));
                }
            }
         
            $db         =  new Database();
            $all_start  =  " $table_name.*, ";

            
        

            if(isset($_REQUEST['field'])){
                if(!empty($_REQUEST['field'])) $all_start = "";
            }



            $where = $isWhere ? " where ".$_REQUEST['where'] : "";

            $query = !empty($fields) && !empty($join) ? "select $all_start $fields from $table_name $join $where" : "select * ". (!empty($fields) ? ",$field" : "" ) ." from $table_name $where ";
            $isMoreTable ? $query =  "select $all_start $fields from $table_name $join $where"  : "";
            $isSubquary  ? $query = "select $table_name.*, $fields from $table_name $join $where" : "";
            $isCont && $query = "select count(*) all_ from $table_name $join $where";
            
            
            /*PARAM*/
            if(isset($_REQUEST['getCampo'])){

                if(!isset($_REQUEST['isJoin'])){
                    $query = "select $table_name.*, $fields from $table_name";   
                }else{
                    $join = trim($_REQUEST['isJoin']);
                    if($join != "true") $query = "select $table_name.*, $fields from $table_name";
                }
            }
            

            $query1 = $query;

            if(isset($_REQUEST['search']) && isset($_REQUEST['fieldSearch'])){
            
                $valor = trim($_REQUEST['search']);
                
                if($valor != ""){

                    $vet      =  explode(',',$_REQUEST['fieldSearch']);
                    $comando  =  "";

                    foreach($vet as $i){

                        if(!empty(trim($i))){
                            $v1 = explode('.',$i);

                            if(count($v1) == 1 ){
                                $comando .= "$table_name.".$i." like '%$valor%' ||";
                            }else{

                                $tb  = $v1[0];
                                $cmp = $v1[1];

                                $comando.= "$tb.".$cmp." like '%$valor%' ||";
                            }
                        }
                    }
    
                    if(strlen($comando)>=2)
                    $comando = substr($comando,0,strlen($comando)-2);
                    $query   = $query." group by $table_name.id having ".$comando;
                    $query1  = $isWhere ? $query1." and ".$comando : $query1." where ".$comando ;
                }
            }

            
            $vet_div       =  explode("from $table_name",$query1);
            $query_count   =  "select count(*) as total from $table_name ".$vet_div[1];

            /* Order */
            
            $query = $query.($isOrder ? " order by ".$_REQUEST["order"]: " order by $table_name.id desc" );     


            $limit      =  isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 0;
            $page       =  isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
            $pular      =  ($page - 1) * $limit;

          
            $query      =  !$isAllPage ? $query." limit $limit offset $pular" : $query;
            

            if(isset($_REQUEST['query'])){
                if(!empty($_REQUEST['query'])){
                    $query = $_REQUEST['query'];
                }
            }
            
            $res        =  $db->queryT($query,$table_name);
            $total      =  $rest->dataArray($db->queryT($query_count,$table_name))[0]['total'];
            $page_all   =  ceil($total/$limit);
            $all        =  $rest->dataArray($res); 
            
            $res['limit']        =  $limit;
            $res['query_count']  =  $query_count;
            $res['data']         =  $isGraph ? $this->graphArray($all) : $all;
            $res['all']          =  $total;
            $res['page_now']     =  $page;
            $res['page_all']     =  $page_all;
            $data                =  $res['data'];

            if(isset($_REQUEST['return'])) return $res;
            echo json_encode($res);
        }

        public function all_cmb($_DATA){

            $table_name   =  $_REQUEST['class'];
            $rest         =   new Rest();
            $db           =   new Database();
            $where        =   isset($_REQUEST['where']) ? " where ".$_REQUEST['where'] : "";
            $res          =   $db->queryT("select *from $table_name $where ",$table_name);
            $res["data"]  =   $rest->dataArray($res);

            echo json_encode($res);
        }

        public function add($_DATA){

            $table_name  =  $_REQUEST['class'];
            $rest        =  new Rest();
            $db          =  new Database();
            $_DATA       =  $rest->replaceNulls($_DATA,false);
            
            $obj         =  $db->add($table_name,$_DATA);
            echo json_encode($obj);
        }

        public function edit($_DATA){
            
            $table_name  =  $_REQUEST['class'];
            $rest        =  new Rest();
            $db          =  new Database();

            if(isset($_DATA['id'])){

                
                if(!empty($_DATA['id'])){
                
                    $id =  $_DATA['id'];
                    unset($_DATA['id']);
                    $_DATA       =  $rest->replaceNulls($_DATA,true);
                    $res = $db->edit($id,$table_name,$_DATA);
                    echo json_encode($res);
                }
                else
                echo json_encode(['status'=>false,'data'=>null,'info'=>'id não foi passado']);
            }
            else
            echo json_encode(['status'=>false,'data'=>null,'info'=>'id não foi passado']);            
        }

    }
?>
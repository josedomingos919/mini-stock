<?php   

    class File{
   
        private const path = "upload/";

        public function uploadAll(){
            $upload = [];
            foreach (array_keys($_FILES) as $key) {

                if(isset($_FILES[$key]["tmp_name"]) && !empty($_FILES[$key]["tmp_name"])){
                    $origem   =  $_FILES[$key]["tmp_name"];
                    $destino  =  self::path.$_FILES[$key]["id"];

                    if(move_uploaded_file($origem,$destino)){
                        $upload[$key] = true;
                    }else{
                        $upload[$key] = false;
                    }
                }
            }

            return $upload;
        }

        public function deletFiles($filename){
            
            $files = "";
            $vet   = explode(',',trim($filename));

            foreach($vet as $item){
                
                if(!empty(trim($item))){

                    $file = self::path.trim($item);
                
                    if(file_exists($file)){
                        $res = unlink($file);

                        if (!$res) {
                            throw new Exception("Cannot delete $filename");
                        }else{
                            $files .= "$item true\n";
                        }
                    }else{
                        $files .= "$item false\n";
                    }
                }
                
            }
            
            return $files;
        }
    }


?>


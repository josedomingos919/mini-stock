<?php

    class Cript  {

        const CODE = "abcdefghijklmnopqrstuvwxyzAPCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
        public $_COUNT = 0;

        private function encript($data, $k){
            $CODE = self::CODE;
            $count = $k===true? mt_rand(0,9): $k;
            $this->_COUNT = $count;
            $p = 0;

            for($i = 0 ; $i< strlen($data); $i++){
                $c = $data[$i];
                $startP = strpos($CODE,$c);

                for($j = 0; $j<$count; $j++){
                    if($k === true){
                        $startP++;
                        if($startP > strlen($CODE)-1) $startP = 0;
                    }else{
                        $startP--;
                        if($startP < 0)  $startP= strlen($CODE)-1;

                    }
                }

                if($startP !== false)
                $data[$i] = $CODE[$startP];
            }

            return $data;
        }
        
        public function encode($data){
            $r = isset($_REQUEST["encode"])? $_REQUEST["encode"] : $data;
            $r = $this->encript($r,true)."¥".$this->_COUNT;
            $CODE = self::CODE;
            $r = base64_encode($CODE."¥".base64_encode($r)."¥".$CODE);

            if (isset($data['return'])) {
                if ($data['return'] == 'true') {
                    echo json_encode($r);
                }
            }

            return $r; 
        }

        public function decode($data){
            $r = isset($_REQUEST["decode"])? $_REQUEST["decode"] : $data;
            $r = base64_decode($r);
            $vet = explode("¥",$r);
            $srt = base64_decode($vet[1]);
            $srt = explode("¥",$srt);
            $valor = $srt[0];
            $cont = $srt[1];
            $result = $this->encript($valor, +$cont);

            if (isset($data['return'])) {
                if ($data['return'] == 'true') {
                    echo json_encode($result);
                }
            }
            
            return  $result;
        }

    }

?>
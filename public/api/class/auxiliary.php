<?php

include_once 'cript.php';

class Aux extends Cript
{
    private $vetErroMessage = [
        '1' => 'Esperava um método!',
        '2' => 'Classe Não existe',
        '3' => 'Metodo não existe',
        '4' => 'Ficheiro não encontrado',
    ];

    public function paginacao($data, $limit)
    {
        $vetPage = [];

        $index = 0;
        $cont = 0;
        $vetAux = [];

        foreach (array_keys($data) as $i) {
            $vetAux[] = $data[$i];
            $cont++;

            if ($cont == $limit) {
                $index++;
                $vetPage[$index] = $vetAux;

                $cont = 0;
                $vetAux = [];
            }
        }

        if (!empty($vetAux)) {
            $index++;
            $vetPage[$index] = $vetAux;
        }

        return $vetPage;
    }

    public function startUpload()
    {
        $newArray = [];
        $data = [];

        if (isset($_FILES)) {
            $i = 0;
            foreach (array_keys($_FILES) as $item) {
                $file = $_FILES[$item];

                if (!empty($file['tmp_name'])) {
                    $file['id'] = empty($file['name'])
                        ? null
                        : date('dmyhis') .
                            $i .
                            '.' .
                            explode('.', $file['name'])['1'];

                    $_FILES[$item]['id'] = $file['id'];

                    if (strpos($item, ',') !== false) {
                        $key = explode(',', $item)[0];

                        if (array_key_exists($key, $newArray)) {
                            $data[$key] .= ',' . $file['id'];
                        } else {
                            $newArray[$key] = $item;
                            $data[$key] = $file['id'];
                        }
                    } else {
                        $data[$item] = $file['id'];
                    }
                    $i++;
                }
            }
        }

        return $data;
    }

    public function dataArray($res)
    {
        $data = [];
        $i = 0;

        while ($row = mysqli_fetch_assoc($res['data'])) {
            $data[$i] = $row;
            $i++;
        }
        return $data;
    }

    public function replaceNulls($data)
    {
        foreach (array_keys($data) as $key) {
            $data[$key] == 'null' ? ($data[$key] = null) : 0;
        }

        return $data;
    }

    public function showErro($valor)
    {
        $info =
            gettype($valor) == 'string'
                ? $valor
                : $this->vetErroMessage[$valor];
        $data = [
            'status' => false,
            'info' => $info,
        ];

        echo json_encode($data);
    }

    public function echoResult($status, $valor, $data, $error, $more)
    {
        $info =
            gettype($valor) == 'string'
                ? $valor
                : $this->vetErroMessage[$valor];
        echo json_encode([
            'status' => $status,
            'data' => $data,
            'error' => $error,
            'more' => $more,
            'info' => $info,
        ]);
    }
}

?>

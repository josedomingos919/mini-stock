<?php

session_start();
$_SESSION['active_routes'] = 3;
require './../../config/util.php';
?>

<!DOCTYPE html>
<html lang="pt-pt">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MiniStock | <?php echo $text; ?></title>
    <link href="./style.css" rel="stylesheet" />
    <link rel="shortcut icon" href="./../../assets/img/icon.png" />
    <script src="../components/loader/index.js"></script>
    <script src="../../config/js/api.js"></script>
    <script src="../../config/js/validate.js"></script>
    <script src="./script.js"></script>
  </head>
  <body>
    <div class="app-container">
      <section class="menu">
        <div class="container-user">
          <div class="user-log">M</div>
          <div class="log-text">iniStock</div>
        </div>

        <?php render_routes(); ?> 

        <div class="container-footer">
          <div class="div-text">Ajuda 24h/24h</div>
          <div class="div-sub-text">Contacte nos todo tempo!</div>
          <div class="div-buttom">Iniciar</div>
        </div>
      </section>

      <section class="app">
        <div class="container-header-title">
          <h4 class="title-page mr-3">
            <i class="<?php echo $icon; ?>"></i>
            <label class="teste-ye"><?php echo $text; ?></label>
          </h4>
          <hr />
        </div>

        <section>
          <div class="mt-4">
          
         <div class="accordion accordion-flush" id="accordionFlushExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
              <button  class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
              <div style="margin-right: 15px;"><i class="fas fa-filter"></i></div> Filtro
              </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">
  
              <div class="form-control pb-3"> 
              <div class="row "> 

              <div class="col-6">
                <label class="form-label">Data Início</label>
                <input placeholder="ex.: Água" required="" type="date" name="nome" minlength="3" class="form-control" id="dataInicio" aria-describedby="emailHelp">
              </div>

              <div class="col-6">
                <label class="form-label">Data Fim</label>
                <input placeholder="ex.: Água" required="" type="date" name="nome" minlength="3" class="form-control" id="dataFim" aria-describedby="emailHelp">
              </div>
              
              
             </div>

             
              <div class="mt-2 "> <hr> </div>
               
              <div  class="row">

              <div class="col-12"> 
                 <button type="button" onclick="loaderFillter()" class="btn btn-light t">Carregar</button>
                 
                 <label>
                  <a id="btnExel" type="button" class="btn btn-success t">
                      <i class="fas fa-print" style="margin-right: 8px"></i>
                      Exportar Excel
                    </a>
                  </label>
              </div>
              
              </div>

              </div>

             
              </div>
            </div>
          </div>
         </div>


              <section  class="product-sec" >
                <div class="t">

                
                <form class="mt-4 from-list" >
                  <table  class="table table-striped table-hover">
                      <thead>
                        <tr><th>ID</th>
                        <th class="not-brack-text">Tipo</th>
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>Quantidade</th>
                        <th>Total Venda</th>
                        <th>Preço Compra</th>
                        <th>Lurco</th>
                        <th>Data</th> 
                        <th>Fatura</th> 
                      </tr></thead>
                      <tbody id="table">
                        <tr>
                          <td></td>
                          <td class="not-brack-text"></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td>
                          <button type="button" class="btn btn-light t"><i class="fas fa-pen-alt"></i></button>  
                    
                          </td>
                          <td>
                            <button type="button" class="btn btn-primary"><i class="fas fa-trash-alt"></i></button>
                          </td>

                        </tr>
                        

                      </tbody>
                  </table>
                </form>
                
                </div>
              </section>

          </div>
        </section>
      </section>
    </div>

    <script src="../../assets/libs/bootstrap-5.1.0-dist/js/bootstrap.js"></script>
   
  </body>
</html>

<?php 

session_start(); 
$_SESSION['active_routes'] = 3;
require('./../../config/util.php');

?>

<!DOCTYPE html>
<html lang="pt-pt">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MiniStock | <?php echo $text ?></title>
    <link href="./style.css" rel="stylesheet" />
    <link rel="shortcut icon" href="./../../assets/img/icon.png" />
  </head>
  <body>
    <div class="app-container">
      <section class="menu">
        <div class="container-user">
          <div class="user-log">M</div>
          <div class="log-text">iniStock</div>
        </div>

        <?php 
            render_routes();
        ?> 

        <div class="container-footer">
          <div class="div-text">Ajuda 24h/24h</div>
          <div class="div-sub-text">Contacte nos todo tempo!</div>
          <div class="div-buttom">Iniciar</div>
        </div>
      </section>

      <section class="app">
        <div class="container-header-title">
          <h4 class="title-page mr-3">
            <i class="<?php echo $icon ?>"></i>
            <label class="teste-ye"><?php echo $text ?></label>
          </h4>
          <hr />
        </div>

        <section>
          <div class="container mt-4">
          
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
           
              <h5>Data Início</h5>
              <div class="row "> 
               <div class="col-4"> 
                   <label for="diaId" class="form-label">Dia</label>
                   <input class="form-control" list="datalistOptionsDiaInicio" id="diaId" placeholder="ex.: 2">
                   <datalist id="datalistOptionsDiaInicio"> 
                       <script>
                         for (let i = 1; i <= 31; i++) {
                           document.write(`<option value="${i}"></option>`);
                         } 
                       </script>
                   </datalist>
               </div>

               <div class="col-3"> 
                   <label for="idMes" class="form-label">Mês</label>
                   <input class="form-control" list="datalistOptionsMes" id="idMes" placeholder="ex.: 3">
                   <datalist id="datalistOptionsMes">
                       <script>
                         for (let c = 1; c <= 12; c++) {
                           document.write(`<option value="${c}"></option>`);
                         } 
                       </script>
                   </datalist>
               </div>

               <div class="col-3">
                 <label class="form-label">Ano</label>
                 <input placeholder="ex.: Ano" required="" type="number" name="nome" class="form-control" aria-describedby="emailHelp">
                 <div class="form-text"></div>
               </div>  

               <div class="mt-2 mb-2"> <hr> </div>
                 
              <h5>Data Fim</h5>
              <div class="row "> 
               <div class="col-3"> 
                   <label for="idCategoria" class="form-label">Dia</label>
                   <input class="form-control" list="datalistOptionsCategoria" id="idCategoria" placeholder="ex.: 2">
                   <datalist id="datalistOptionsCategoria"> 
                       <script>
                         for (let i = 1; i <= 31; i++) {
                           document.write(`<option value="${i}"></option>`);
                         } 
                       </script>
                   </datalist>
               </div>

               <div class="col-3"> 
                   <label for="idMes" class="form-label">Mês</label>
                   <input class="form-control" list="datalistOptionsMes" id="idMes" placeholder="ex.: 3">
                   <datalist id="datalistOptionsMes">
                       <script>
                         for (let c = 1; c <= 12; c++) {
                           document.write(`<option value="${c}"></option>`);
                         } 
                       </script>
                   </datalist>
               </div>

               <div class="col-3">
                 <label class="form-label">Ano</label>
                 <input placeholder="ex.: Ano" required="" type="number" name="nome" class="form-control" aria-describedby="emailHelp">
                 <div class="form-text"></div>
               </div>  
             </div>

             
             <div class="mt-2"> <hr> </div>
               <div class="col-3"> 
                 <button type="button" class="btn btn-light t">Carregar</button>
               </div>

               </div>

             
              </div>
            </div>
          </div>
         </div>


              <section  class="product-sec" >
                <div class="container t">

                
                <form class="mt-4 from-list t" >
                  <table class="table table-striped table-hover">
                      <thead>
                        <tr><th>ID</th>
                        <th class="not-brack-text">Nome</th>
                        <th>Categoria</th>
                        <th>Quantidade</th>
                        <th>Preço Compra</th>
                        <th>Preço Venda</th>
                        <th>Total Unitário</th>
                        <th>Preço Revendedor</th>
                        <th>Total Revendedor</th>
                        <th>Data</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                      </tr></thead>
                      <tbody>
                        <tr>
                          <td>lkjhg</td>
                          <td class="not-brack-text">lkjhg</td>
                          <td>lkjhg</td>
                          <td>lkjhg</td>
                          <td>lkjhg</td>
                          <td>lkjhg</td>
                          <td>lkjhg</td>
                          <td>lkjhg</td>
                          <td>lkjhg</td>
                          <td>lkjhg</td>
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

                  <div class="mt-4">
                      <nav aria-label="Page navigation example mt-5">
                        <ul class="pagination justify-content-center">
                          <li class="page-item ">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true"> &laquo; </a>
                          </li>
                          <li class="page-item"><a class="page-link" href="#">1</a></li>
                          <li class="page-item"><a class="page-link" href="#">2</a></li>
                          <li class="page-item"><a class="page-link" href="#">3</a></li>
                          <li class="page-item">
                            <a class="page-link" href="#"> &raquo; </a>
                          </li>
                        </ul>
                      </nav>
                  </div>
              
                </div>
              </section>

          </div>
        </section>
      </section>
    </div>

    <script src="../../assets/libs/bootstrap-5.1.0-dist/js/bootstrap.js"></script>
  </body>
</html>

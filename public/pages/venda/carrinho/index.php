<?php 

session_start(); 
$_SESSION['active_routes'] = 1;
require('./../../../config/util.php');

?>

<!DOCTYPE html>
<html lang="pt-pt">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MiniStock | <?php echo $text ?></title>
    <link href="./style.css" rel="stylesheet" />
    <link rel="shortcut icon" href="./../../../assets/img/icon.png" />
    <script src="../../../config/js/cart.js"></script>
    <script src="../../../config/js/api.js"></script>
    <script src="../../../config/js/validate.js"></script>
    <script src="./script.js"></script>
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
            <i class="fab fa-buffer"></i>
            <label class="teste-ye"><?php echo $text ?></label>
          </h4>
          <hr />
        </div>

        <!--Header-->
        <section class="mt-4">
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a
                style="color: #00000063"
                class="nav-link"
                style="color: black"
                aria-current="page"
                href="/pages/venda/vender/"
                ><i class="fas fa-clipboard-list"></i> Produtos</a
              >
            </li>
            <li class="nav-item">
              <a
                style="color: #fb6d3a"
                class="nav-link active"
                style="color: black"
                aria-current="page"
                href="/pages/venda/carrinho/"
                ><i class="fas fa-cart-arrow-down"></i> Carrinho
                <span id="spnCarrinho">( 0 )</span></a
              >
            </li>
          </ul>
        </section>

        <div class="accordion accordion-flush mt-3 menu-cart" id="accordionFlushExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne"> 
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#flush-collapseOne"
                aria-expanded="false"
                aria-controls="flush-collapseOne"
              >
              <i class="fas fa-clipboard-check" style="margin-right: 10px;"></i>  Produtos selecionado 
              </button> 
            </h2>
            <div
              id="flush-collapseOne"
              class="accordion-collapse collapse"
              aria-labelledby="flush-headingOne"
              data-bs-parent="#accordionFlushExample"
            >  
                <!--Body-->
                <form class="mt-2 from-list k">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th class="not-brack-text">Foto</th>
                        <th class="not-brack-text">Nome</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Total</th>
                        <th style="text-align: center">Salvar</th>
                        <th style="text-align: center">Eliminar</th>
                      </tr>
                    </thead>
                    <tbody id="table"></tbody>
                  </table>
                </form> 

            </div>
          </div>
 
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingTwo">
              <button
                id="btnPayOption"
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#flush-collapseTwo"
                aria-expanded="false"
                aria-controls="flush-collapseTwo"
              >
              <i style="margin-right: 10px;" class="fas fa-money-bill-alt"></i>Pagamento
              </button>
            </h2>
            <div
              id="flush-collapseTwo"
              class="accordion-collapse collapse"
              aria-labelledby="flush-headingTwo"
              data-bs-parent="#accordionFlushExample"
            >
              <div class="accordion-body">
                <div class="div-total">
                  <label>TOTAL</label>
                  <label>3674885 AOA</label>
                </div>
                 
              </div>
            </div>
          </div>
 
        </div>


        <div class="mt-4">
          <nav aria-label="Page navigation example mt-5">
            <ul
              id="ulPagination"
              class="pagination justify-content-center"
            ></ul>
          </nav>
        </div>
      </section>
    </div>

    <script src="../../../assets/libs/bootstrap-5.1.0-dist/js/bootstrap.js"></script>
    <script src="../../components/loader/index.js"></script>
  </body>
</html>

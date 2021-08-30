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

        <div
          class="accordion accordion-flush mt-3 menu-cart"
          id="accordionFlushExample"
        >
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
                <i
                  class="fas fa-clipboard-check"
                  style="margin-right: 10px"
                ></i>
                Produtos selecionado
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
                <i style="margin-right: 10px" class="fas fa-money-bill-alt"></i
                >Pagamento
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
                  <div class="rows t">
                    <label>TOTAL</label>
                    <label id="lbl_total">0,00 AOA</label>
                  </div>
                  <div class="rows a">
                    <label>Valor Pago</label>
                    <label id="lbl_pagar">0,00 AOA</label>
                  </div>
                  <div class="rows a">
                    <label>Diferença ( Troco )</label>
                    <label id="lbl_troco">0,00 AOA</label>
                  </div>
                  <div class="rows a">
                    <label>Qt. Produto</label>
                    <label id="lbl_prod">( 0,00 )</label>
                  </div>
                </div>

                <div class="row mt-3">
                  <div class="col-3">
                    <label>Valor dado:</label>
                    <input
                      id="tdQt0"
                      class="form-control"
                      type="number"
                      min="1"
                      aria-label=".form-control-sm example"
                      onchange="onchangeValor(this.value)"
                      onkeyup="onchangeValor(this.value)"
                    />
                  </div>
                  <div class="col-3">
                    <label>Metódo de Pagamento:</label>
                    <select class="form-control">
                      <option value=""></option>
                      <option value="money">DINHEIRO</option>
                      <option value="tpa">POS/TPA</option>
                    </select>
                  </div>
                  
                </div>

                <div class="row">
                  <div class="col-12 pt-4" >
                    <button
                      id="btnSalvar"
                      type="button"
                      class="btn btn-light t"
                    >
                      <i
                        style="margin-right: 8px"
                        class="fas fa-check-square"
                      ></i>
                      Finalizar Compra
                    </button>
                    <label>
                      <button
                        id="btnSalvarEnter"
                        type="button"
                        class="btn btn-danger t"
                      >
                        <i
                          style="margin-right: 8px"
                          class="fas fa-backspace"
                        ></i>
                        Cancelar
                      </button>
                    </label>
                    <button
                      id="btnSalvarCancelar"
                      type="button"
                      class="btn btn-success t"
                    >
                      <i class="fas fa-print" style="margin-right: 8px"></i>
                      Imprimir
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <script src="../../../assets/libs/bootstrap-5.1.0-dist/js/bootstrap.js"></script>
    <script src="../../components/loader/index.js"></script>
  </body>
</html>

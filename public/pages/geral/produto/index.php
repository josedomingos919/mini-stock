<?php 

session_start(); 
$_SESSION['active_routes'] = 2;
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
    <script src="../../../config/js/api.js"></script>
    <script src="../../../config/js/validate.js"></script>
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
              <a style="color: #fb6d3a;" class="nav-link active"  aria-current="page" href="/pages/geral/produto/"><i class="fas fa-box"></i> Produto</a>
            </li>
            <li class="nav-item">
              <a style="color: #00000063;" class="nav-link" style="color: black;" aria-current="page" href="/pages/geral/produto/listar/"><i class="fas fa-clipboard-list"></i> Listar Produtos</a>
            </li> 
            <li class="nav-item">
              <a  style="color: #00000063;"  class="nav-link" style="color: black;" aria-current="page" href="/pages/geral/categoria/"><i class="fas fa-filter"></i> Categoria</a>
            </li> 
            <li class="nav-item">
              <a  style="color: #00000063;"  class="nav-link" style="color: black;" aria-current="page" href="/pages/geral/categoria/listar/"><i class="fas fa-clipboard-list"></i> Listar Categoria</a>
            </li> 
          </ul>
        </section>

        <!--Body-->
        <form id="form" class="mt-4">

          <div class="row mb-4">

            <div class="col-7">
              <label class="form-label">Nome</label>
              <input placeholder="ex.: Água" required type="text" name="nome" minlength="3" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              <div class="form-text"></div>
            </div> 

            <div class="col-5">
              <label class="form-label">Preço de compra</label>
              <input placeholder="ex.: 1.000 AOA" required type="number" name="preco_compra" minlength="3" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              <div class="form-text"></div>
            </div> 

            <div class="col-7"> 
                <label for="categoriaId" class="form-label">Categoria</label>
                <input name="categoriaId" required class="form-control" list="datalistOptions" id="categoriaId" placeholder="ex.: Bebida">
                <datalist id="datalistOptions">
                  <option value="San Francisco"></option>
                  <option value="New York"></option>
                  <option value="Seattle"></option>
                  <option value="Los Angeles"></option>
                  <option value="Chicago"></option>
                </datalist>
            </div>

            <div class="col-5">
              <label class="form-label">Preço de venda</label>
              <input placeholder="ex.: 7,000 AOA" required type="number" name="preco_venda" minlength="3" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              <div class="form-text"></div>
            </div> 

            <div class="col-4">
              <label class="form-label">Preço para revendedor</label>
              <input placeholder="ex.: 7,000 AOA" required type="number" name="preco_venda" minlength="3" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              <div class="form-text"></div>
            </div> 

            <div class="col-3">
              <label class="form-label">Quantidade</label>
              <input placeholder="ex.: 20 Un" required type="number" name="quantidade" minlength="3" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              <div class="form-text"></div>
            </div> 

          </div> 

            <button style="margin-right: 7px;" type="submit" class="btn btn-primary mr-2">Salvar</button>
            <button type="button" class="btn btn-light t">Limpar</button>
  
        </form>
        
      </section>
    </div>

    <script src="../../../assets/libs/bootstrap-5.1.0-dist/js/bootstrap.js"></script>
  </body>
</html>

<?php 

session_start(); 
$_SESSION['active_routes'] = 2;
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
            <i class="fab fa-buffer"></i>
            <label class="teste-ye"><?php echo $text ?></label>
          </h4>
          <hr />
        </div>

        <!--Header-->
        <section>
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a style="color: #fb6d3a;" class="nav-link active"  aria-current="page" href="#"><i class="fas fa-box"></i> Produto</a>
            </li>
            <li class="nav-item">
              <a style="color: #00000063;" class="nav-link" style="color: black;" aria-current="page" href="#"><i class="fas fa-clipboard-list"></i> Listar Produtos</a>
            </li> 
            <li class="nav-item">
              <a  style="color: #00000063;"  class="nav-link" style="color: black;" aria-current="page" href="#"><i class="fas fa-filter"></i> Categoria</a>
            </li> 
            <li class="nav-item">
              <a  style="color: #00000063;"  class="nav-link" style="color: black;" aria-current="page" href="#"><i class="fas fa-clipboard-list"></i> Listar Categoria</a>
            </li> 
          </ul>
        </section>
      </section>
    </div>

    <script src="../../assets/libs/bootstrap-5.1.0-dist/js/bootstrap.js"></script>
  </body>
</html>

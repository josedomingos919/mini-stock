<!DOCTYPE html>
<html lang="pt-pt">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MiniStock | Fatura</title>
    <link href="./style.css" rel="stylesheet" />
    <link rel="shortcut icon" href="./../../../assets/img/icon.png" />
    <script src="../../../config/js/cart.js"></script>
    <script src="../../../config/js/api.js"></script>
    <script src="../../../config/js/validate.js"></script>
    <script src="./script.js"></script>
    <script src="./../../../assets/libs/qrcodejs/qrcode.min.js"></script>
  </head>
  <body> 
    <main class="main-form">
      <section class="secMain">
          <div>
            <div class="txtFat" id="txtFat"><b>FATURA</b></div> 
            <div><b>Nº:</b><span id="lbl_text"></span></div>
            <div><b>Morada:</b> Viana Calemba 2, Rua 1, Luanda Angola</div>
            <div><b>NIF: </b>5000059869</div>
            <div><b>TEL: </b>+244 944 666 640</div>
            <div><b>EMAIL: </b>josedomingos919@gmail.com</div>
          </div>
          <div class="divRight"> 
              <div><b>ArixVenda</b><div>
              <div id="qrFat"></div>
          </div>
      </section>
      
      <div class="hrDiv"></div>

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th class="not-brack-text">Nome</th>
            <th>Preço</th>
            <th>Quantidade</th>
            <th>Total</th> 
          </tr>
        </thead>
        <tbody id="table"></tbody>
      </table>

      <div>
        <div>Subtotal: <span id="subtotal"></span></div> 
        <div class="mt-2"><b>TOTAL</b>: <span id="totaldv"></span></div>
        

        <div class="hrDiv"></div>
        <div>Valor dado: <span id="valorDado"></span><div>
        <div>Diferença/Troco: <span id="diferenca"></span><div>
        <div id="txtTEp"></div>
        <br><br>
        
      <div>
      <div class="text">
        Power By MiniStock
      </div>
      <div class="subTextHour" id="subTextHour">

      </div>
    </main>

    <script src="../../../assets/libs/bootstrap-5.1.0-dist/js/bootstrap.js"></script>
    <script src="../../components/loader/index.js"></script>
  </body>
</html>

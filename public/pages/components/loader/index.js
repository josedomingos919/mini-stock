var _loader = {
  show() {
    const html = `
          
          <div class="loaderDv">
            <div class="loaderRJ"></div>
          </div>
          <style>
            .loaderDv {
              z-index: 100;
              top: 0;
              left: 0;
              position: fixed;
              width: 100%;
              height: 100%;
              background-color: rgba(0, 0, 0, 0.5);
              display: flex;
              justify-content: center;
              align-items: center;
            }
      
            .loaderRJ {
              border: 16px solid #f3f3f3;
              border-radius: 50%;
              border-top: 16px solid rgb(255 255 255 / 76%);
              border-right: 16px solid rgb(231 231 243 / 40%);
              border-bottom: 16px solid rgb(255 255 255 / 16%);
              border-left: 16px solid rgb(175 175 175 / 24%);
              width: 50px;
              height: 50px;
              -webkit-animation: spin 1s linear infinite;
              animation: spin 1s linear infinite;
            }
      
            @-webkit-keyframes spin {
              0% {
                -webkit-transform: rotate(0deg);
              }
              100% {
                -webkit-transform: rotate(360deg);
              }
            }
      
            @keyframes spin {
              0% {
                transform: rotate(0deg);
              }
              100% {
                transform: rotate(360deg);
              }
            }
          </style>
    `;
    const div = document.createElement("div");
    div.setAttribute("id", "loader1324");
    div.innerHTML = html;
    document.body.appendChild(div);
  },
  hide() {
    document.getElementById("loader1324").remove();
  },
};

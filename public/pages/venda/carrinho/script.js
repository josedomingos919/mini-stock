var produtoData = [];

async function incialize(page = 1, limit = 5) {
  const table = document.getElementById("table");
  table.innerHTML = "";

  _loader.show();
  const response = cart.get();
  _loader.hide();

  if (response.length) {
    const vet = response;
    produtoData = vet;

    table.innerHTML = vet
      .map(
        ({ id, nome, foto, preco_venda, quantidade_, total_ }, index) => `
        <tr>
            <td>${id}</td>
            <td><img class="img-prod" src="${FileLink + foto}" /></td>
            <td class="not-brack-text" >${nome}</td> 
            <td>${formatNumber(preco_venda)} AOA</td> 
            <td><input value="${quantidade_}" id="tdQt${index}" onchange="calcularTotal(${index},this.value)"  onkeyup="calcularTotal(${index},this.value)"  style="width: 88px;" class="form-control form-control-sm" type="number" min="1" aria-label=".form-control-sm example"> </td>
            <td style="min-width: 100px;" id="tdTotal${index}" >${
          total_ + " AOA"
        }</td>
            <td style="text-align: center;">
                <button onclick="saveInCart(${index})" type="button" class="btn btn-light t"> <i class="fas fa-save"></i> </button>  
            </td> 
            <td style="text-align: center;">
                <button onclick="saveInCart(${index})" type="button" class="btn btn-danger t"> <i class="fas fa-trash"></i> </button>  
            </td> 
        </tr>
      `
      )
      .join(" ");

    MakePagination(response);
  } else {
    alert("Nenhum dado foi encontrado!");
  }
}

window.onload = async () => {
  updateCartTotal();
  const params = getUrlparams();
  incialize(params?.page, params?.limit);
};

function getUrlparams() {
  try {
    const result = {};

    location.search
      .substring(1)
      .split("&")
      .map((e) => ({
        [e.split("=")?.[0]]: e.split("=")?.[1],
      }))
      .forEach((e) => {
        if (Object.keys(e)?.[0])
          result[Object.keys(e)?.[0]] = Object.values(e)?.[0];
      });

    return result;
  } catch {
    return {};
  }
}

function MakePagination(response) {
  const { page_all, page_now } = response;
  const pageContainer = document.getElementById("ulPagination");

  console.log("response", response);

  let paginatioRenderHtml = ``;

  //Pagination
  if (page_all > 1) {
    for (let i = 1; i <= page_all; i++) {
      paginatioRenderHtml += `
            <li class="page-item">
                <a ${
                  i == page_now ? ` style="color: #fb6d3a;"` : ``
                } class="page-link" href="/pages/geral/produto/listar/?page=${i}">${i}</a>
            </li> 
        `;
    }
  } else {
    return ``;
  }

  //Back
  if (+page_now !== 1) {
    paginatioRenderHtml = `
    <li class="page-item ">
        <a class="page-link" href="/pages/geral/produto/listar/?page=${
          +page_now - 1
        }" tabindex="-1" aria-disabled="true"> « </a>
    </li>
    ${paginatioRenderHtml}
`;
  } else {
    paginatioRenderHtml = `
    <li class="page-item disabled">
        <a class="page-link" href="#" tabindex="-1" aria-disabled="false"> « </a>
    </li>
    ${paginatioRenderHtml}
`;
  }

  //Next
  if (+page_now !== page_all) {
    paginatioRenderHtml += `  
        <li class="page-item">
            <a class="page-link" href="/pages/geral/produto/listar/?page=${
              +page_now + 1
            }"> » </a>
        </li>
    `;
  } else {
    paginatioRenderHtml += `  
        <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1" aria-disabled="false"> » </a>
        </li>
    `;
  }

  //Render
  pageContainer.innerHTML = paginatioRenderHtml;
}

async function calcularTotal(index, quantidade) {
  const { preco_venda } = produtoData[index];
  const td = document.getElementById("tdTotal" + index);

  const total = formatNumber(preco_venda * quantidade);

  if (total) {
    produtoData[index].quantidade_ = quantidade;
    produtoData[index].total_ = total;
  } else {
    delete produtoData[index].quantidade_;
    delete produtoData[index].total_;
    cart.remove(produtoData[index]?.id);
  }

  td.innerHTML = total ? total + " AOA" : "-";
}

function saveInCart(index) {
  if (produtoData[index].total_) {
    cart.set(produtoData[index]);
    updateCartTotal();
  } else {
    alert("Esperava receber á quantidade!");
  }
}

function updateCartTotal() {
  document.getElementById("spnCarrinho").innerHTML = `( ${cart.get().length} )`;
  incialize();
}

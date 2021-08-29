var produtoData = [];

async function incialize(page = 1, limit = 5) {
  const table = document.getElementById("table");
  table.innerHTML = "";

  _loader.show();
  const response = await Api.all("produto", {
    page,
    limit,
    moreTable: "categoria.id produto.id_categoria",
    leftJoin: true,
  });
  _loader.hide();

  if (response.data.length) {
    const vet = response.data;
    produtoData = vet;

    table.innerHTML = vet
      .map(
        (
          {
            data_,
            id,
            nome,
            foto,
            quantidade,
            preco_revendedor,
            preco_compra,
            preco_venda,
            CATEGORIA_nome,
          },
          index
        ) => `
        <tr>
            <td>${id}</td>
            <td><img class="img-prod" src="${FileLink + foto}" /></td>
            <td class="not-brack-text" >${nome}</td>
            <td>${CATEGORIA_nome}</td>
            <td>${formatNumber(preco_compra)} AOA</td>
            <td>${formatNumber(preco_venda)} AOA</td>
            <td>${formatNumber(preco_revendedor)} AOA</td>
            <td>${quantidade}</td>
            <td>${data_}</td>
            <td>
                <button onclick="update(${index})" type="button" class="btn btn-light t"><i class="fas fa-pen-alt"></i></button>  
            </td>
            <td>
                <button onclick="deleteItem(${index})" type="button" class="btn btn-primary"><i class="fas fa-trash-alt"></i></button>
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
  const { page_all, page_now, all } = response;
  const pageContainer = document.getElementById("ulPagination");
  const spanTotal = document.getElementById("totalData");

  console.log("response", response);

  spanTotal.innerHTML = `( ${all} )`;

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

async function deleteItem(index) {
  const { id, foto } = produtoData[index];

  if (confirm("Está preste a eliminar um item ?")) {
    _loader.show();
    const response = await Api.delete("produto", { id, unlink: foto });
    if (response.status) {
      alert("Eliminado com sucesso!");
      location.reload();
    } else {
      alert("Falha ao eliminar!");
    }
    _loader.hide();
  }
}

async function update(i) {
  sessionStorage.setItem("produtoData", JSON.stringify(produtoData[i]));
  location.href = "/pages/geral/produto/";
}

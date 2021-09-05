var produtoData = []

async function incialize(dataInicio, dataFim) {
  const table = document.getElementById('table')
  table.innerHTML = ''

  _loader.show()
  const response = await Api.all('vwapuramento', {
    allPage: true,
    where:
      dataInicio && !dataFim
        ? ` date_ = '${dataInicio}' `
        : dataInicio && dataFim
        ? ` date_ >= '${dataInicio}' and date_ <= '${dataFim}' `
        : ``,
  })
  _loader.hide()

  console.log(response)

  if (response.data.length) {
    const vet = response.data
    produtoData = vet

    console.log('response', response)

    table.innerHTML = vet
      .map(
        (
          {
            id,
            tipo,
            foto,
            nomeProduto,
            quantidade,
            totalVenda,
            preco_compra,
            lucro,
            data_,
          },
          index,
        ) => `
        <tr>
            <td>${id}</td>
            <td>${tipo}</td>
            <td><img class="img-prod" src="${FileLink + foto}" /></td>
            <td class="not-brack-text" >${nomeProduto}</td>
            <td>${quantidade}</td>
            <td>${formatNumber(totalVenda)} AOA</td>
            <td>${formatNumber(preco_compra)} AOA</td>
            <td>${formatNumber(lucro)} AOA</td> 
            <td>${data_}</td>
            <td>
                <button onclick="printForm(${id})" type="button" class="btn btn-success"> <i class="fas fa-print"></i> </button>  
            </td>
             
        </tr>
      `,
      )
      .join(' ')

    generateCSV(vet)
  } else {
    alert('Nenhum dado foi encontrado!')
  }
}

function loaderFillter() {
  incialize(dataInicio.value, dataFim.value)
}

window.onload = async () => {
  const params = getUrlparams()
  incialize(params?.page, params?.limit)
}

function getUrlparams() {
  try {
    const result = {}

    location.search
      .substring(1)
      .split('&')
      .map((e) => ({
        [e.split('=')?.[0]]: e.split('=')?.[1],
      }))
      .forEach((e) => {
        if (Object.keys(e)?.[0])
          result[Object.keys(e)?.[0]] = Object.values(e)?.[0]
      })

    return result
  } catch {
    return {}
  }
}

async function deleteItem(index) {
  const { id, foto } = produtoData[index]

  if (confirm('Está preste a eliminar um item ?')) {
    _loader.show()
    const response = await Api.delete('produto', { id, unlink: foto })
    if (response.status) {
      alert('Eliminado com sucesso!')
      location.reload()
    } else {
      alert('Falha ao eliminar!')
    }
    _loader.hide()
  }
}

async function update(i) {
  sessionStorage.setItem('produtoData', JSON.stringify(produtoData[i]))
  location.href = '/pages/geral/produto/'
}

function printForm(id = '') {
  const iframe = document.createElement('iframe')
  iframe.style.display = 'none'
  iframe.setAttribute('src', `http://ministock.pt/pages/venda/fatura/?id=${id}`)
  document.body.appendChild(iframe)
  _loader.show()
  iframe.contentWindow.addEventListener('DOMContentLoaded', () => {
    _loader.hide()
  })
}

function generateCSV(vet) {
  const linkExel = document.getElementById('btnExel')
  var arrayContent = [
    ['ID,TIPO,NOME,QUANTIDADE,TOTAL VENDA,PREÇO COMPRA,LUCRO,DATA'],
    ...vet.map(
      ({
        id,
        tipo,
        nomeProduto,
        quantidade,
        totalVenda,
        preco_compra,
        lucro,
        data_,
      }) => [
        `${id},${tipo},${nomeProduto},${quantidade},${formatNumber(
          totalVenda,
        )} AOA,${formatNumber(preco_compra)} AOA,${formatNumber(
          lucro,
        )} AOA,${data_}`,
      ],
    ),
  ]

  var csvContent = arrayContent.join('\n')
  linkExel.setAttribute(
    'href',
    'data:text/csv;charset=utf-8,%EF%BB%BF' + encodeURI(csvContent),
  )
  linkExel.setAttribute('download', `apuramento_${new Date().getTime()}.csv`)
}

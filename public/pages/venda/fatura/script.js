var produtoData = []

function setFormDateTime() {
  const data = new Date()
  subTextHour.innerHTML = `${data.getDate()}/${data.getMonth()}/${data.getFullYear()}  ${data.getHours()}:${data.getMinutes()}:${data.getSeconds()} `
}

async function incialize() {
  const { id, tipo } = getUrlparams()
  setFormDateTime()

  if (tipo == 'porforma') {
    txtFat.innerHTML = `FATURA PORFORMA`
    lbl_text.innerHTML = '***'

    table.innerHTML = cart
      .get()
      .map(
        ({ id, nome, quantidade_, total_, preco_venda }) => `
      <tr>
          <td>${id}</td> 
          <td>${nome}</td> 
          <td>${formatNumber(preco_venda)} AOA</td> 
          <td>${quantidade_}</td> 
          <td>${formatNumber(total_)} AOA</td> 
      </tr>
    `,
      )
      .join(' ')

    subtotal.innerHTML = `${formatNumber(cart.getTotal())} AOA`
    totaldv.innerHTML = `${formatNumber(cart.getTotal())} AOA`

    //window.print()
    return
  } else {
    if (id)
      new QRCode(document.getElementById('qrFat'), {
        text: id,
        width: 100,
        height: 100,
      })
  }

  const response = await Api.all('venda', { where: 'id = ' + id })
  console.log(response)

  if (response?.status) {
    const [venda] = response.data
    subtotal.innerHTML = `${formatNumber(venda.total)} AOA`
    totaldv.innerHTML = `${formatNumber(venda.total)} AOA`
    txtTEp.innerHTML = `[ <b>${venda.tipo}</b> ] `
    document.getElementById('lbl_text').innerHTML = (() =>
      id < 10 ? `00${id}` : id < 100 ? `0${id}` : id)()
  }

  const responseProd = await Api.all('produtovenda', {
    where: 'produtovenda.venda_id = ' + id,
    moreTable: `produto.id produtovenda.produto_id`,
  })

  if (responseProd?.status) {
    table.innerHTML = responseProd.data
      .map(
        ({
          PRODUTO_id,
          PRODUTO_nome,
          quantidade,
          total,
          PRODUTO_preco_venda,
        }) => `
        <tr>
            <td>${PRODUTO_id}</td> 
            <td>${PRODUTO_nome}</td> 
            <td>${formatNumber(PRODUTO_preco_venda)} AOA</td> 
            <td>${quantidade}</td> 
            <td>${formatNumber(total)} AOA</td> 
        </tr>
      `,
      )
      .join(' ')
  }
}

window.onload = async () => {
  incialize()
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

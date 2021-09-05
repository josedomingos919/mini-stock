var produtoData = []
var valorDado = 0

async function incialize() {
  updateCartTotal()
  document.getElementById('btnSalvarCancelar').addEventListener('click', () => {
    printForm('')
  })

  const table = document.getElementById('table')
  table.innerHTML = ''

  const response = cart.get()

  if (response.length) {
    const vet = response
    produtoData = vet

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
          total_ + ' AOA'
        }</td>
            <td style="text-align: center;">
                <button onclick="saveInCart(${index})" type="button" class="btn btn-light t"> <i class="fas fa-save"></i> </button>  
            </td> 
            <td style="text-align: center;">
                <button onclick="delteInCart(${id})" type="button" class="btn btn-danger t"> <i class="fas fa-trash"></i> </button>  
            </td> 
        </tr>
      `,
      )
      .join(' ')
  }
}

window.onload = async () => {
  updateCartTotal()
  const params = getUrlparams()
  incialize()
  lbl_total.innerHTML = formatNumber(cart.getTotal()) + ' AOA'

  const form = document.getElementById('formDev')
  form.addEventListener('submit', async (e) => {
    e.preventDefault()

    const valorDado = document.getElementById('inputPreco').value
    const valorPagar = cart.getTotal()
    const method = document.getElementById('selectInput').value

    if (valorDado < valorPagar) {
      alert('Valor insuficiente!')
    } else {
      _loader.show()
      const responseVendaAdd = await Api.add('venda', {
        valor_pago: valorDado,
        troco: getDiferenca(),
        total: cart.getTotal(),
        estado: 'vendido',
        tipo: method,
      })

      const { status, inserted_id } = responseVendaAdd || {}

      if (status) {
        for (e of cart.get()) {
          const item = await Api.add('produtovenda', {
            produto_id: e?.id,
            venda_id: inserted_id,
            quantidade: e?.quantidade_,
            preco: e?.preco_venda,
            total: +e?.preco_venda * +e?.quantidade_,
          })

          console.log(item)
        }

        _loader.hide()
        alert('Venda feita com sucesso!')
        cart.clear()
        window.location.href = '/pages/venda/vender/'
      } else {
        alert('Falha ao vender!')
      }

      console.log('responseVendaAdd', responseVendaAdd)
    }

    console.log('teste', cart.get())
  })
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

async function calcularTotal(index, quantidade) {
  const { preco_venda } = produtoData[index]
  const td = document.getElementById('tdTotal' + index)

  const total = formatNumber(preco_venda * quantidade)

  if (total) {
    produtoData[index].quantidade_ = quantidade
    produtoData[index].total_ = total
  } else {
    delete produtoData[index].quantidade_
    delete produtoData[index].total_
    cart.remove(produtoData[index]?.id)
  }

  td.innerHTML = total ? total + ' AOA' : '-'
}

function saveInCart(index) {
  if (produtoData[index].total_) {
    cart.set(produtoData[index])
    location.reload()
  } else {
    alert('Esperava receber á quantidade!')
  }
}

function delteInCart(id) {
  if (
    confirm('Está preste a remover um item do carrinho!\nDesejas Continuar ?')
  ) {
    cart.remove(id)
    location.reload()
  }
}

function updateCartTotal() {
  const quantidade = cart.get().length
  lbl_prod.innerHTML = '( ' + quantidade + ' )'
  document.getElementById('spnCarrinho').innerHTML = `( ${quantidade} )`
}

let open = false
function hidePaySection() {
  open = !open
  if (open) {
    btnPayOption.style.display = 'none'
  } else {
    btnPayOption.style.display = ''
  }
}

function onchangeValor(valor) {
  valorDado = valor
  lbl_pagar.innerHTML = (formatNumber(valor) || 0) + ',00 AOA'
  lbl_troco.innerHTML = valor
    ? formatNumber(getDiferenca()) + ' ,00 AOA'
    : '0,00 AOA'
}

function getDiferenca() {
  return Math.abs(cart.getTotal() - valorDado)
}

function printForm(id = '') {
  const valorDado = document.getElementById('inputPreco').value
  const iframe = document.createElement('iframe')
  iframe.style.display = 'none'
  iframe.setAttribute(
    'src',
    id !== ''
      ? `http://ministock.pt/pages/venda/fatura/?id=${id}`
      : `http://ministock.pt/pages/venda/fatura/?id=10&tipo=porforma&pago=${valorDado}&diferenca=${getDiferenca()}`,
  )
  document.body.appendChild(iframe)
  _loader.show()
  iframe.contentWindow.addEventListener('DOMContentLoaded', () => {
    iframe.contentWindow.print()
    _loader.hide()
  })
}

function cancelSale() {
  if (confirm('Está preste a cancelar a venda\nContinuar ?')) {
    cart.clear()
    window.location.href = '/pages/venda/vender/'
  }
}

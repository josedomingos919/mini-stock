var dataCategoria = [];

window.onload = () => {
  inicialize();
  const form = document.getElementById("form");

  const dataEdit = sessionStorage.getItem("produtoData");

  if (dataEdit) {
    setUpdateData(dataEdit);
  }

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    let dataEdit = sessionStorage.getItem("produtoData");

    //Validation
    if (Validar.isInvalid(form)) return;

    const id_categoria = dataCategoria.find(
      (e) => e?.label == form?.value?.id_categoria
    )?.value;

    if (!id_categoria) {
      alert("Categoria não identificada!");
      return;
    }

    const dataAdd = {
      ...form.value,
      id_categoria,
    };

    //Editar
    if (dataEdit) {
      dataEdit = JSON.parse(dataEdit);

      _loader.show();

      const response = await Api.edit("produto", {
        ...dataAdd,
        id: dataEdit?.id,
      });

      _loader.hide();

      if (response?.status) {
        sessionStorage.removeItem("produtoData");
        alert("Salvo com sucesso!");
        location.reload();
      } else {
        alert("Não foi possivel salvar!");
      }

      return;
    }

    //Adicionar
    _loader.show();
    const response = await Api.add("produto", dataAdd);
    _loader.hide();

    if (response?.status) {
      alert("Salvo com sucesso!");
      Validar.limparForm(form);
    } else {
      alert("Não foi possivel salvar!");
    }
  });
};

function setUpdateData(data) {
  const form = document.getElementById("form");
  data = JSON.parse(data);
  const span = document.getElementById("spn_label");

  console.log("data", data);
  Validar.setFormValue({ ...data, id_categoria: data?.CATEGORIA_nome }, form);
  span.innerHTML = " / Editar";
}

async function inicialize() {
  /* Categoria */
  const inputCategoria = document.getElementById("categoriaId");
  inputCategoria.setAttribute("disabled", true);

  const data = (await Api.all("categoria")).data.map(({ nome, id }) => ({
    label: nome,
    value: id,
  }));

  if (!data.length) {
    inputCategoria.setAttribute("placeholder", "Sem dados!");
  } else {
    dataCategoria = data;
    const options = document.getElementById("datalistOptionsCategoria");
    inputCategoria.removeAttribute("disabled");

    options.innerHTML = data
      .map((e) => `<option value="${e?.label}" ></option>`)
      .join("");
  }
}

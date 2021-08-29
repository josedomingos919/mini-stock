var dataCategoria = [];

window.onload = () => {
  inicialize();
  const form = document.getElementById("form");

  const dataEdit = sessionStorage.getItem("categoriaData");

  if (dataEdit) {
    setUpdateData(dataEdit);
  }

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    let dataEdit = sessionStorage.getItem("categoriaData");

    //Validation
    if (Validar.isInvalid(form)) return;

    const id_categoria = dataCategoria.find(
      (e) => e?.label == form?.value?.id_categoria
    )?.value;

    //Editar
    if (dataEdit) {
      dataEdit = JSON.parse(dataEdit);

      _loader.show();

      const response = await Api.edit("categoria", {
        nome: input.value,
        id: dataEdit.id,
      });

      _loader.hide();

      if (response?.status) {
        sessionStorage.removeItem("categoriaData");

        alert("Salvo com sucesso!");
        input.value = "";
        location.reload();
      } else {
        alert("Não foi possivel salvar!");
      }

      return;
    }

    if (!id_categoria) {
      alert("Categoria não identificada!");
      return;
    }

    const dataAdd = {
      ...form.value,
      id_categoria,
    };

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
  return;
  data = JSON.parse(data);
  const span = document.getElementById("spn_label");

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

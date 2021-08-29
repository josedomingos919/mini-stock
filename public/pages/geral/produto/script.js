window.onload = () => {
  const form = document.getElementById("form");

  const dataEdit = sessionStorage.getItem("categoriaData");

  if (dataEdit) {
    setUpdateData(dataEdit);
  }

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    let dataEdit = sessionStorage.getItem("categoriaData");

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

    //Adicionar
    _loader.show();
    const response = await Api.add("categoria", { nome: input.value });
    _loader.hide();

    if (response?.status) {
      alert("Salvo com sucesso!");
      input.value = "";
    } else {
      alert("Não foi possivel salvar!");
    }
  });
};

function setUpdateData(data) {
  data = JSON.parse(data);
  const input = document.getElementById("inputName");
  const span = document.getElementById("spn_label");
  input.value = data.nome;

  span.innerHTML = " / Editar";
}

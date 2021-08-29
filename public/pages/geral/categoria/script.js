window.onload = () => {
  const form = document.getElementById("form");
  const input = document.getElementById("inputName");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    _loader.show();
    const response = await Api.add("categoria", { nome: input.value });
    _loader.hide();
    if (response?.status) {
      alert("Salvo com sucesso!");
      input.value = "";
    } else {
      alert("Não foi possivel salvar!");
    }
    console.log("response", response);
  });
};

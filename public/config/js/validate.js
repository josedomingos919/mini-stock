const FileLink__ = "http://ministock.pt/api/upload/";
class validarCs {
  constructor() {
    this.limpar();
  }

  fillHtml = (obj) => {
    Object.keys(obj).map((key) => {
      let item = document.querySelector(`[name="${key}"]`);
      if (item) {
        item.innerHTML = obj[key] || "";
      }
    });
  };

  fillSelect = (
    data = [{ select, label, value: "id", table, init, method: "all_cmb" }]
  ) => {
    data.forEach((item) => {
      let {
        select,
        label,
        value = "id",
        table,
        init,
        method = "all_cmb",
      } = item;

      select.innerHTML = `<option value="">${init}</option>`;

      Server.Api.Send(null, table, method, ({ data: { data } }) => {
        if (data.length == 1) {
          select.setAttribute("disabled", "");
          select.innerHTML =
            "<option value='" + data[0].id + "'>" + data[0].nome + "</option>";
        } else {
          for (let obj of data) {
            select.innerHTML +=
              "<option value='" + obj[value] + "'>" + obj[label] + "</option>";
          }
        }
      });
    });
  };

  setInputFiles = (input, link, fileName) => {
    this.getFileFromUrl(link + fileName, fileName)
      .then((e) => {
        this.putFileInInput(input, e, true);
      })
      .catch((e) => console.log(e));
  };

  putFileInInput = (input, file, change) => {
    let dt = new DataTransfer();
    for (let el of input.files) {
      dt.items.add(el);
    }
    dt.items.add(file);
    input.files = dt.files;
    if (change == true) input.onchange();
  };

  getFileFromUrl = async (url, fileName) => {
    let extencao = fileName.split(".")[1];
    let response = await fetch(url);
    let data = await response.blob();
    let file = new File([data], fileName, { type: extencao });
    return file;
  };

  //Gerar data
  getFormData(form) {
    if (!form) return null;

    let ElSelect = form.querySelectorAll("select");
    let ElInput = form.querySelectorAll("input");
    let ElTextarea = form.querySelectorAll("textarea");
    let component = [...ElSelect, ...ElInput, ...ElTextarea];

    let data = {};
    let vetImg = {};

    for (let item of component) {
      if (item.attributes.not) continue;

      if (item.type == "file") {
        if (item.getAttribute("name")) {
          if (item.getAttribute("name"))
            vetImg[item.getAttribute("name")] =
              item.files.length == 1 ? item.files[0] : [...item.files];
        }
      }

      if (item.type == "url" || "text" || "email" || "textarea") {
        if (item.getAttribute("name"))
          data[item.getAttribute("name")] = item.value;
      }

      if (item.type == "select") {
        if (item.getAttribute("name"))
          data[item.getAttribute("name")] = item.value.trim()
            ? null
            : item.value.trim();
      }

      if (item.type == "number") {
        if (item.getAttribute("name"))
          data[item.getAttribute("name")] =
            item.value.trim() == "" ? null : item.value.trim();
      }
    }

    let rest = { ...data, ...vetImg };
    return rest;
  }

  //Inform
  showINFO(data) {
    let { campo, sms } = data;
    let retorno = true;

    if (campo != "") {
      let c = document.querySelector("label[name='" + campo + "']");
      c ? (c.innerHTML = sms) : (retorno = sms);
    } else {
      retorno = sms;
    }

    return retorno;
  }

  //limpar form
  limparForm = (frm, not = [""]) => {
    let vet = [
      ...frm.getElementsByTagName("input"),
      ...frm.getElementsByTagName("textarea"),
    ];
    for (const input of vet) {
      let { name } = this.getValidator(input);
      let i = not.indexOf(name);
      if (i < 0 && input.type !== "button") input.value = null;
    }

    vet = document.getElementsByTagName("select");

    for (const cmb of vet) {
      let { name } = this.getValidator(cmb);
      let i = not.indexOf(name);
      if (i < 0) cmb.selectedIndex = 0;
    }

    let vetImg = document.getElementsByTagName("img");

    for (const img of vetImg) {
      let { name } = this.getValidator(img);
      let i = not.indexOf(name);
      if (i < 0) {
        let att = img.getAttribute("def");
        att ? (img.src = att) : 0;
      }
    }
  };

  //limpar
  limpar = () => {
    let vet = document.querySelectorAll(".info");
    for (let lbl of vet) {
      lbl.innerHTML = "";
      lbl.style = "";
    }
  };

  setSelectedElement = (select, value, option, change = false) => {
    let vetOption = select.querySelectorAll("option");
    select.optionValue = option ? value : null;

    for (let i of vetOption) {
      if (i.value == value || i.text == value) {
        i.selected = true;
        if (select.onchange && change == true) select.onchange();
      }
    }
  };

  //setFormData
  setFormValue = (data, form, callBack) => {
    for (var e in data) {
      let input =
        form.querySelector(
          'input[name="' + e + '"],textarea[name="' + e + '"]'
        ) ||
        form.querySelector('input[alt="' + e + '"],textarea[alt="' + e + '"]');
      let select =
        form.querySelector('select[name="' + e + '"]') ||
        form.querySelector('select[alt="' + e + '"]');

      if (select) {
        let { unSet } = this.getValidator(select);
        if (!unSet) this.setSelectedElement(select, data[e], true, true);
      }

      if (input)
        if (input.getAttribute("type") !== "file") {
          if (input.getAttribute("type") == "datetime-local")
            input.value = data[e].replace(" ", "T");
          else input.value = data[e];

          let att = input.getAttribute("radio");
          if (att) {
            let radio = document.querySelector(
              `input[type='radio'][${att}='true'][state="${data[e]}"]`
            );
            radio.checked = true;
          }
        } else {
          let vet = data[e]?.split(",") || [];
          input.files = new DataTransfer().files;

          vet.map((e) => {
            if (e.trim() !== "") this.setInputFiles(input, FileLink__, e);
          });
        }
    }
    if (callBack) callBack({ data, form });
  };

  //Validar Email
  eEmail = (valor) => {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(valor)) {
      return true;
    }
    return false;
  };

  //Contain
  contain = (str, char) => {
    if (char.length > 1 || char.length == 0) return null;
    return str.indexOf(char) >= 0 ? true : false;
  };

  //Rest Re
  getlabel(input) {
    let lbl = null;
    if (input.getAttribute("label")) {
      lbl = document.querySelector("#" + input.getAttribute("label"));
    } else {
      lbl = input.parentElement.querySelector("label");
    }
    console.log("label", lbl);
    input.label = lbl;
  }

  //Validator
  getValidator = (input) => {
    if (input) {
      this.getCampo("all", input);
    } else {
      return null;
    }

    let id = input.getAttribute("confirmid");

    let vMinc = input.getAttribute("minchar");
    return {
      required: input.getAttribute("required") != null ? true : false,
      notspace: input.getAttribute("notspace") != null ? true : false,
      minchar: vMinc != null ? vMinc : false,
      inputconf: id != null ? document.getElementById(id) : null,
      def:
        input.getAttribute("def") != null ? input.getAttribute("def") : false,
      unSet: input.getAttribute("unSet") != null ? true : false,
      name: input.getAttribute("name"),
    };
  };

  //Pegar campo
  getCampo = (inp, input) => {
    let condicao =
      typeof inp == "string" ? inp + "".toLocaleLowerCase() == "all" : null;

    if (condicao) {
      input.campo = input;
      try {
        input.valor = input.value.trim();
      } catch (e) {}
      input.tipo = input.getAttribute("tipo");
      return;
    }

    return inp.id ? inp.id.split("_")[1] : null;
  };

  //erro not space
  notSpaceError = (input) => {
    let { notspace } = this.getValidator(input);

    if (notspace && this.contain(input.value, " ")) {
      this.activeInfo("Campo não pode conter espaço", input.campo, true);
      console.warn("Not Space");
      console.log(input);
      return true;
    }

    return false;
  };

  //erro char senha
  mincharSenhaError = (input) => {
    let validator = this.getValidator(input);
    let { minchar } = validator;

    if (
      input.valor.length < minchar &&
      input.valor.length >= 1 &&
      validator.minchar
    ) {
      this.activeInfo("Nº de caracteres minimo: " + minchar, input.campo, true);
      console.warn("Parou em validar caracter");
      return true;
    }

    return false;
  };

  activeInfo = (sms, input, boll) => {
    console.log("antive smsm", [input]);
    //console.log("22",input);
    console.log(input);
    if (input?.label) input.label.style = "display: initial;";
    input?.label
      ? (input.label.innerHTML = "*" + sms)
      : console.log("labelError");
  };

  //Investigar especificar tipo de variavel no parametro
  isInvalid = (form) => {
    this.limpar();
    let travou = false;
    let vetInput = [
      ...form.getElementsByTagName("input"),
      ...form.getElementsByTagName("textarea"),
    ];
    let notValidar = [
      ...document.querySelectorAll("input[not],select[not],textarea[not]"),
    ];

    for (const input of vetInput) {
      this.getCampo("all", input);
      this.getlabel(input);

      //Atributos para
      const validator = this.getValidator(input);

      //console.log(validator);
      //console.log(input);
      //Validar num caracter

      if (input.type == "password" || "text" || "email") {
        let { minchar } = validator,
          prop = false;

        if (this.mincharSenhaError(input)) {
          travou = prop = true;
          console.warn("Parou em validar caracter");
        }
      }

      //Texto
      if (input.type == "text") {
        let { required, notspace } = validator;
        let prop = false;

        //Verificar se é obrigatório
        if (required && input.valor == "") {
          travou = prop = true;
          this.activeInfo("Campo não pode estar vazio!", input.campo, true);
          console.warn("Required txt: ");
          console.log(input);
        }

        //Contem espaço
        if (this.notSpaceError(input) && !prop) {
          travou = prop = true;
        }

        //é do tipo user
        if (input.tipo == "user") {
          if (!prop && this.contain(input.valor, " ")) {
            travou = prop = true;
            this.activeInfo("Campo não pode conter espaço", input.campo, true);
            console.warn("User");
            console.log(input);
          }
        }
      }

      //URL
      if (input.type == "url") {
        const { required, inputconf } = validator;
        let prop = false;

        if (required && input.valor == "") {
          travou = prop = true;
          this.activeInfo("Campo não pode estar vazio!", input.campo, true);
          console.warn("required URL");
          console.log(input);
        }
      }

      //Textarea
      if (input.type == "textarea") {
        const { required, inputconf } = validator;
        let prop = false;

        if (required && input.valor == "") {
          travou = prop = true;
          this.activeInfo("Campo não pode estar vazio!", input.campo, true);
          console.warn("required Textarea");
          console.log(input);
        }
      }

      //Password
      if (input.type == "password") {
        const { required, inputconf } = validator;
        let prop = false;

        if (required && input.valor == "") {
          travou = prop = true;
          this.activeInfo("Campo não pode estar vazio!", input.campo, true);
          console.warn("required Password");
          console.log(input);
        }

        if (input.valor != "" && !prop && inputconf) {
          if (
            input.valor != inputconf.value &&
            input.valor != "" &&
            inputconf.value != ""
          ) {
            let cmp = this.getCampo(inputconf);
            travou = prop = true;
            this.activeInfo("Senha diferente!", input.campo, true);
            this.activeInfo("Senha diferente!", input.cmp, true);
            console.warn("confirmar senha");
            console.log(input);
          }
        }
      }

      //Numero
      if (input.type == "number" || input.type == "tel") {
        const { required } = validator;

        if (required && input.valor == "") {
          this.activeInfo("Campo não pode estar vazio!", input.campo, true);
          travou = true;
          console.warn("parou em numero Required");
          console.log(input);
        }
      }

      //Email
      if (input.type == "email") {
        const { required } = validator;
        let prop = false;

        if (required && input.valor == "") {
          this.activeInfo("Campo não pode estar vazio!", input.campo, true);
          prop = travou = true;
          console.warn("parou em email Required");
          console.log(input);
        }

        if (input.valor.length > 0 && !prop && !this.eEmail(input.valor)) {
          travou = true;
          this.activeInfo("Email Inválido!", input.campo, true);
          console.warn("parou em email invalido");
          console.log(input);
        }
      }

      //File
      if (input.type == "file") {
        const { required } = validator;
        console.log("file Input", input);
        if (!input.files[0] && required) {
          travou = true;
          console.warn("parou em input file");
          this.activeInfo("Campo obrigatório!", input.campo, true);
          console.log(input);
        }
      }

      //Date
      if (input.type == "date" || "datetime-local") {
        const { required } = validator;

        if (input.valor.length == 0 && required) {
          travou = true;
          this.activeInfo("Campo obrigatório!", input.campo, true);
          console.warn("parou em imput data");
          console.log(input);
        }
      }
    }

    let vetCmb = form.getElementsByTagName("select");
    for (const cmb of vetCmb) {
      if (notValidar.includes(cmb)) continue;
      //Vars
      this.getCampo("all", cmb);
      this.getlabel(cmb);

      //Atributos para
      let { required } = this.getValidator(cmb);

      if (cmb.value.trim() == "" && required) {
        this.activeInfo("Campo obrigatório!", cmb.campo, true);
        travou = true;
        //console.warn('parou no select: '+ cmb.id);
        console.log(cmb);
      }
    }

    console.log(travou);

    if (!travou) {
      form.value = this.getFormData(form);
    }

    return travou;
  };
}

const Validar = new validarCs();
window.Validar = Validar;

const baseURL = "http://ministock.pt/api/";
const FileLink = baseURL + "upload/";

const Api = {
  Send(data_ = {}, class_ = "", method_ = "") {
    let formData = new FormData();
    for (let key in data_) {
      if (typeof data_[key] == "object" && data_[key]) {
        if (data_[key].length) {
          let i = 0;
          for (let item of data_[key]) {
            formData.append(key + "," + i, item);
            i++;
          }
        } else {
          formData.append(key, data_[key]);
        }
      } else {
        formData.append(key, data_[key]);
      }
    }

    return fetch(baseURL + "/" + class_ + "/" + method_, {
      method: "POST",
      body: formData,
    })
      .then((r) => r.json())
      .then((data) => {
        data = Config.mysqlError(data);
        return data;
      })
      .catch((e) => {
        return e;
      });
  },
  edit(class_, data = {}) {
    return Api.Send(data, class_, "edit");
  },
  add(class_, data = {}) {
    return Api.Send(data, class_, "add");
  },
  all(class_, data = {}) {
    return Api.Send(data, class_, "all");
  },
  delete(class_, data = {}) {
    return Api.Send(data, class_, "remove");
  },
};

const Config = {
  server: {
    url: baseURL,
  },
  mysqlError: (data) => {
    if (!data) return null;
    if (data.status) return data;
    if (!data.error) return data;

    let refectorCampo = (valor) => {
      return valor.substring(1, campo.length - 1);
    };

    let { errno, error } = data.error;

    data["erroType"] = null;
    data["campo"] = null;

    let sms = error.split(" ");
    let campo = "";

    switch (errno) {
      case 1364:
        campo = sms[1];
        data["sms"] = "Valor não pode ser nulo!";
        return data;

      case 1054:
        campo = sms[2];
        data["sms"] = "Campo (" + campo + ") não existe na base de dados!";
        return data;

      case 1146:
        data["sms"] =
          "O programa não encontrou um local para armazenar estes dados!";
        return data;

      case 1062:
        campo = sms[5];
        data["sms"] = "Registo já existe!";
        data["campo"] = refectorCampo(campo);
        data["erroType"] = "unique";
        return data;

      case 1366:
        campo = sms[6];
        data["sms"] = "Valor incorrecto!";
        data["campo"] = refectorCampo(campo);
        data["erroType"] = "invalido";
        return data;

      case 1064:
        data["erroType"] = "syntax";
        data["sms"] =
          "Campo não identificado com valor incorrecto! verifique todos os campos";
        return data;

      case 1406:
        campo = sms[5];
        data["sms"] = "Valor muito longo!!!";
        data["campo"] = refectorCampo(campo);
        data["erroType"] = "longo";
        return data;

      default:
        data["sms"] = "Erro não identificado";
        return data;
    }
  },
};

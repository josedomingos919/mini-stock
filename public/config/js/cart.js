class minCart {
  get() {
    return JSON.parse(localStorage.cart || "[]");
  }
  getTotal() {
    try{ 
      return this.get()
      .map(({ quantidade_, preco_venda }) => +quantidade_ * +preco_venda)
      .reduce((a = 0, b = 0) => a + b);
    }catch {
      return 0
    }
  }
  set(item) {
    localStorage.setItem(
      "cart",
      JSON.stringify([item, ...this.get().filter(({ id }) => id !== item.id)])
    );
  }
  getIds() {
    return this.get().map(({ id }) => id);
  }
  remove(id_) {
    localStorage.setItem(
      "cart",
      JSON.stringify(this.get().filter(({ id }) => +id !== +id_))
    );
  }
}

const cart = new minCart();

class minCart {
  get() {
    return JSON.parse(localStorage.cart || "[]");
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
      JSON.stringify(this.get().filter(({ id }) => id !== id_))
    );
  }
}

const cart = new minCart();

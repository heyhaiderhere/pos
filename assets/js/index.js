const products = document
  .querySelector(".products-container")
  .querySelectorAll(".product-card:not(.add-new)");
console.log(products);
const sellSection = document.querySelector(".sell-products");
const billingData = document.querySelector(".sell-sub-total");
const quantityButtons = document.querySelectorAll(".quantity-buttons");
const sellAndDinning = document.querySelector(".sell-and-dinning");
const sellAndDinningLabel = document.querySelector(".sell-and-dinning-label");
const paymentStatus = document.querySelector(".payment-status");
const paymentStatusLabel = document.querySelector(".payment-status-label");
sellAndDinning.addEventListener("change", (e) => {
  e.target.checked
    ? (sellAndDinningLabel.innerText = "Dinning")
    : (sellAndDinningLabel.innerText = "Sell");
});
paymentStatus.addEventListener("change", (e) => {
  e.target.checked
    ? (paymentStatusLabel.innerText = "paid")
    : (paymentStatusLabel.innerText = "unpaid");
});
// console.log(quantityButtons);
let productSellArray = [];
products.forEach((product) => {
  product.addEventListener("click", (e) => {
    // console.log(product.querySelector(".product-image").getAttribute("src"));
    let found = false;
    for (let i = 0; i < productSellArray.length; i++) {
      if (productSellArray[i]?.productId === product.dataset.productid) {
        if (productSellArray[i]?.quantity >= product.dataset.inStock) return;
        productSellArray[i].quantity++;
        found = true;
        break;
      }
    }
    if (!found) {
      productSellArray.push({
        productId: product.dataset.productid,
        quantity: 1,
        inStock: product.dataset.inStock,
        image: product.querySelector(".product-image").getAttribute("src"),
        productName: product.querySelector(".product-name").innerText,
        unitPrice: +product.querySelector(".unit-price").innerText,
      });
    }
    // console.log(productSellArray);
    renderSellList(productSellArray);
  });
});
function setQuantity(productId, dialact, stock) {
  for (let i = 0; i < productSellArray.length; i++) {
    if (productSellArray[i]?.productId === productId) {
      if (dialact === "decremeant") {
        if (productSellArray[i]?.quantity === 1) return;
        productSellArray[i].quantity--;
      } else {
        if (productSellArray[i]?.quantity >= stock) return;
        productSellArray[i].quantity++;
      }
    }
  }
  renderSellList(productSellArray);
  //   console.log(productId);
}

function deleteSellProduct(productId) {
  console.log(productId, productSellArray);
  const filterdArr = productSellArray.filter((product) => {
    return product.productId !== productId;
  });

  productSellArray = filterdArr;
  renderSellList(productSellArray);
}

function renderSellList(products) {
  billingData.innerText = "";
  sellSection.innerHTML = "";
  if (products.length === 0) return;
  products.forEach((product) => {
    const productRow = document.createElement("div");
    const heroWidget = document.createElement("div");
    const quantityContainer = document.createElement("div");
    const productImage = document.createElement("img");
    const productName = document.createElement("p");
    const unitPrice = document.createElement("p");
    const priceContainer = document.createElement("div");
    const increamentButton = document.createElement("button");
    const decreamentButton = document.createElement("button");
    const deleteButton = document.createElement("button");
    const productQuantity = document.createElement("p");
    decreamentButton.addEventListener("click", () => {
      setQuantity(product?.productId, "decremeant", product?.inStock);
    });
    increamentButton.addEventListener("click", () => {
      setQuantity(product?.productId, "increament", product?.inStock);
    });
    deleteButton.addEventListener("click", () => {
      deleteSellProduct(product?.productId);
    });
    decreamentButton.classList.add("quantity-buttons");
    increamentButton.classList.add("quantity-buttons");
    decreamentButton.dataset.productId = product?.productId;
    increamentButton.dataset.productId = product?.productId;
    increamentButton.innerText = "+";
    decreamentButton.innerText = "-";
    deleteButton.innerHTML = "&#10060;";
    productName.innerText = `${product?.productName}`;
    unitPrice.innerText = `${product?.unitPrice}`;
    productQuantity.innerText = `${product?.quantity}`;
    productRow.classList.add("sell-row");
    quantityContainer.classList.add("sell-row-quantity-container");
    heroWidget.classList.add("sell-row-hero-widget");
    deleteButton.classList.add("sell-row-delete-button");
    productImage.src = product?.image;
    productImage.classList.add("sell-row-image");
    heroWidget.append(productImage);
    priceContainer.append(productName);
    priceContainer.append(unitPrice);
    heroWidget.append(priceContainer);
    productRow.append(heroWidget);
    quantityContainer.append(decreamentButton);
    quantityContainer.append(productQuantity);
    quantityContainer.append(increamentButton);
    quantityContainer.append(deleteButton);
    productRow.append(quantityContainer);
    sellSection.append(productRow);
  });
  const totalAmount = products.reduce((acc, item) => {
    let subtotal = item.unitPrice * item.quantity;
    return acc + subtotal;
  }, 0);
  billingData.innerText = totalAmount;
}

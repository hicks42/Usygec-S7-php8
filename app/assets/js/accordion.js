let blocks = document.querySelectorAll("#accordion .item .header");
let items = document.querySelectorAll(".item");
blocks.forEach((block) => {
  block.addEventListener("click", (e) => {
    let currentItem = e.currentTarget.closest(".item");
    let isActive = currentItem.classList.contains("active");

    setAllInactive(items);

    if (!isActive) {
      currentItem.classList.add("active");
    }
  });
});

function setAllInactive(items) {
  items.forEach((item) => {
    item.classList.remove("active");
  });
}

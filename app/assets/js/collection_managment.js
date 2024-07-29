const addFormToCollection = (e) => {
  const collectionHolder = document.querySelector(
    "." + e.currentTarget.dataset.collectionHolderClass
  );
  const item = document.createElement("li");
  item.className = `bg-slate-200 my-[1px] rounded-md p-2`;
  item.innerHTML = collectionHolder.dataset.prototype.replace(
    /__name__/g,
    collectionHolder.dataset.index
  );
  collectionHolder.appendChild(item);
  collectionHolder.dataset.index++;
  addFormDeleteLink(item);
};

const addFormDeleteLink = (item) => {
  const removeFormButton = document.createElement("button");
  removeFormButton.innerText = "Supprimer X";
  removeFormButton.className = `btn btn-sm btn-danger opacity-90 w-fit p-1 m-2`;

  item.append(removeFormButton);

  removeFormButton.addEventListener("click", (e) => {
    e.preventDefault();
    item.remove();
  });
};

document.querySelectorAll("div.etbl-card").forEach((group) => {
  addFormDeleteLink(group);
});

document.querySelectorAll("ul.structures li").forEach((structure) => {
  addFormDeleteLink(structure);
});

document.querySelectorAll(".add_item_link").forEach((btn) => {
  btn.addEventListener("click", addFormToCollection);
});

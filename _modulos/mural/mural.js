const fileInputMultiple = document.getElementById("upload-file-multiple");
const uploadedImgsContainer = document.querySelector(
  ".uploaded-imgs-container"
);
const tipoMuralSelect = document.getElementById("tipos_mural");
const quantidadeModal = new bootstrap.Modal(
  document.getElementById("mural-quantidade-modal")
);

tipoMuralSelect.addEventListener("change", () => {
  const tipoMural = tipoMuralSelect.value;
  if (tipoMural === "unico") {
    const images = uploadedImgsContainer.querySelectorAll(
      "div.position-relative"
    );
    if (images.length > 1) {
      images.forEach((imgContainer, index) => {
        if (index < images.length - 1) {
          imgContainer.remove();
        }
      });
    }
  }
});

fileInputMultiple.addEventListener("change", (e) => {
  const files = e.target.files;
  const tipoMural = tipoMuralSelect.value;
  const existingImagesCount = uploadedImgsContainer.querySelectorAll(
    "input[name^='imagem']"
  ).length;

  let maxImages = 0;
  if (tipoMural === "unico") {
    maxImages = 1;
  } else if (tipoMural === "carrosel") {
    maxImages = 10;
  }

  if (existingImagesCount + files.length > maxImages) {
    quantidadeModal.show();
    fileInputMultiple.value = "";
    return;
  }

  Array.from(files).forEach((file, index) => {
    const src = URL.createObjectURL(file);

    const img = new Image();
    img.src = src;
    img.onload = () => {
      const imgContainer = document.createElement("div");
      imgContainer.classList.add(
        "position-relative",
        "h-120-px",
        "w-120-px",
        "border",
        "input-form-light",
        "radius-8",
        "overflow-hidden",
        "border-dashed",
        "bg-neutral-50"
      );

      const removeButton = document.createElement("button");
      removeButton.type = "button";
      removeButton.classList.add(
        "uploaded-img__remove",
        "position-absolute",
        "top-0",
        "end-0",
        "z-1",
        "text-2xxl",
        "line-height-1",
        "me-8",
        "mt-8",
        "d-flex"
      );
      removeButton.innerHTML =
        '<iconify-icon icon="radix-icons:cross-2" class="text-xl text-danger-600"></iconify-icon>';

      const imagePreview = document.createElement("img");
      imagePreview.classList.add("w-100", "h-100", "object-fit-cover");
      imagePreview.src = src;

      const inputImagem = document.createElement("input");
      inputImagem.type = "file"; // Agora é tipo file, para envio no backend
      inputImagem.classList.add("d-none");
      inputImagem.name = `imagem[${existingImagesCount + index}]`;

      // Criar um DataTransfer para adicionar o arquivo
      const dataTransfer = new DataTransfer();
      dataTransfer.items.add(file);
      inputImagem.files = dataTransfer.files; // Atribuindo o arquivo ao input

      imgContainer.appendChild(removeButton);
      imgContainer.appendChild(inputImagem);
      imgContainer.appendChild(imagePreview);
      uploadedImgsContainer.appendChild(imgContainer);

      removeButton.addEventListener("click", () => {
        URL.revokeObjectURL(src);
        imgContainer.remove();
      });
    };
  });

  // Limpar o campo de input para permitir novos uploads
  fileInputMultiple.value = "";
});

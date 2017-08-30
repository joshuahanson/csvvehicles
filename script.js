var mainImage = document.getElementById("main-vehicle-image-container");
mainImage.addEventListener("click", mainImageZoom);

function mainImageZoom() {
  mainImage.classList.toggle('image-is-zoomed');
}
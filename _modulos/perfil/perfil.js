// ======================== Upload Image Start =====================
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $("#imagePreview").css(
        "background-image",
        "url(" + e.target.result + ")"
      );
      $("#imagePreview").hide();
      $("#imagePreview").fadeIn(650);
    };
    reader.readAsDataURL(input.files[0]);
  }
}
$("#imageUpload").change(function () {
  readURL(this);
});
// ======================== Upload Image End =====================
if (window.location.href.includes("perfil")) {
  $("#imagePreview").css("background-image", "url(" + imagemUsuario + ")");
}

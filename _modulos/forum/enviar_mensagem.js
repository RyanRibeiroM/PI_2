document
  .getElementById("chatForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    var mensagem = document.getElementById("mensagemInput").value;

    $.ajax({
      url: "/forum/enviar-mensagem",
      type: "POST",
      data: {
        id_forum: id_forum,
        id_usuario: id_usuario,
        mensagem: mensagem,
      },
      success: function (response) {
        document.getElementById("mensagemInput").value = "";
        buscarMensagens();
        rolarParaBaixo();
      },
      error: function (error) {
        console.error("Erro ao enviar mensagem:", error);
      },
    });
  });

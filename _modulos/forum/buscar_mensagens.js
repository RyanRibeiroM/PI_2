function rolarParaBaixo() {
  var chatMessageList = document.querySelector(".chat-message-list");
  if (chatMessageList) {
    setTimeout(() => {
      chatMessageList.scrollTop = chatMessageList.scrollHeight;
    }, 100);
  }
}

function buscarMensagens() {
  $.ajax({
    url: "/forum/nova-mensagem",
    type: "POST",
    data: { id_forum: id_forum },
    dataType: "json",
    success: function (data) {
      var mensagensContainer = $(".chat-message-list");
      var mensagensExistentes = mensagensContainer.children();
      var mensagensExistentesIds = [];

      mensagensExistentes.each(function () {
        mensagensExistentesIds.push($(this).data("id"));
      });

      if (data.length === 0) {
        mensagensContainer.children(".chat-single-message").remove();
        var emptyMessageElement = document.getElementById("emptyMessage");
        if (emptyMessageElement) {
          emptyMessageElement.style.display = "block";
        }
      } else {
        var emptyMessageElement = document.getElementById("emptyMessage");
        if (emptyMessageElement) {
          emptyMessageElement.style.display = "none";
        }
        data.forEach(function (mensagem) {
          if (!mensagensExistentesIds.includes(mensagem.id)) {
            var mensagemHtml = "";

            if (mensagem.remetente == id_usuario) {
              mensagemHtml +=
                '<div class="chat-single-message right" data-id="' +
                mensagem.id +
                '">';
            } else {
              mensagemHtml +=
                '<div class="chat-single-message left" data-id="' +
                mensagem.id +
                '">';
              mensagemHtml +=
                '<img src="' +
                mensagem.imagemPerfil +
                '" alt="imagem" class="avatar-lg object-fit-cover rounded-circle">';
            }

            mensagemHtml += '<div class="chat-message-content">';
            if (mensagem.remetente != id_usuario) {
              mensagemHtml +=
                '<small class="mb-5 ">' + mensagem.remetente_nome + "</small>";
            }
            mensagemHtml += '<p class="mb-3">' + mensagem.conteudo + "</p>";
            mensagemHtml +=
              '<p class="chat-time mb-0"><span>' +
              mensagem.dataEnvio +
              "</span></p>";
            mensagemHtml += "</div></div>";

            mensagensContainer.append(mensagemHtml);
            novaMensagem = true;
          }
        });

        if (novaMensagem) {
          document.getElementById("newMessageIndicator").style.display =
            "block";
        }
      }
    },
    error: function (error) {
      console.error("Erro ao buscar mensagens:", error);
    },
  });
}

// Chama a função buscarMensagens a cada 2 segundos
setInterval(function () {
  buscarMensagens();
}, 2000);

// Chama a função buscarMensagens e atualizarListaForuns ao carregar a página
document.addEventListener("DOMContentLoaded", function () {
  atualizarListaForuns();
  buscarMensagens(); // Certifique-se de buscar mensagens antes
  rolarParaBaixo();
});

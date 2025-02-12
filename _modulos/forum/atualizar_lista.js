function atualizarListaForuns() {
  $.ajax({
    url: "/forum/atualizar-lista",
    type: "POST",
    dataType: "json",
    success: function (data) {
      var forumListContainer = $(".chat-all-list");
      forumListContainer.empty();

      if (data.length === 0) {
        forumListContainer.append(
          '<p class="m-3">Nenhum fórum disponível.</p>'
        );
      } else {
        data.forEach(function (forum) {
          var forumHtml = "<hr>";
          forumHtml +=
            '<a href="/forum/' +
            forum.id +
            '" class="chat-sidebar-single active forum-conteiner">';
          forumHtml += '<div class="info">';
          forumHtml +=
            '<h6 class="text-sm mb-1 forum-nome">' + forum.nome + "</h6>";
          if (forum.ultima_mensagem) {
            forumHtml += '<p class="mb-0 text-xs">';
            forumHtml +=
              forum.ultima_mensagem.length > 16
                ? forum.ultima_mensagem.substring(0, 16) + "..."
                : forum.ultima_mensagem;
            forumHtml += "</p>";
          }
          forumHtml += "</div>";
          forumHtml += '<div class="action text-end">';
          if (forum.ultima_mensagem) {
            forumHtml +=
              '<p class="mb-0 text-neutral-400 text-xs lh-1">' +
              formatarDataMensagem(forum.dataEnvio) +
              "</p>";
          }
          forumHtml += "</div></a>";
          forumListContainer.append(forumHtml);
        });
        forumListContainer.append("<hr>");
      }
    },
    error: function (error) {
      console.error("Erro ao atualizar lista de fóruns:", error);
    },
  });
}

function formatarDataMensagem(dataEnvio) {
  const dataAtual = new Date();
  const dataMensagem = new Date(dataEnvio);

  const diferencaTempo = dataAtual - dataMensagem;
  const umDiaEmMilissegundos = 24 * 60 * 60 * 1000;

  if (
    diferencaTempo < umDiaEmMilissegundos &&
    dataAtual.getDate() === dataMensagem.getDate()
  ) {
    // Mesma data
    return dataMensagem.toLocaleTimeString([], {
      hour: "2-digit",
      minute: "2-digit",
    });
  } else if (
    diferencaTempo < 2 * umDiaEmMilissegundos &&
    dataAtual.getDate() - dataMensagem.getDate() === 1
  ) {
    // Ontem
    return `ontem às ${dataMensagem.toLocaleTimeString([], {
      hour: "2-digit",
      minute: "2-digit",
    })}`;
  } else {
    // Data completa
    return `${dataMensagem.toLocaleDateString(
      "pt-BR"
    )} ${dataMensagem.toLocaleTimeString([], {
      hour: "2-digit",
      minute: "2-digit",
    })}`;
  }
}

setInterval(function () {
  atualizarListaForuns();
}, 2000);
atualizarListaForuns();

function copyToClipboard(text) {
  navigator.clipboard.writeText(text).then(function() {
      /* alert("Link copiado!"); */
  }, function(err) {
      console.error('Erro ao copiar o texto: ', err);
  });
}
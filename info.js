document.getElementById("comment-button").addEventListener("click", function() {
    const commentBox = document.getElementById("comment-box");
    commentBox.style.display = commentBox.style.display === "none" ? "block" : "none";
});

document.getElementById("submit-comment").addEventListener("click", function() {
    const commentInput = document.getElementById("comment-input").value;
    if (commentInput) {
        // Aqui você pode adicionar lógica para salvar o comentário, como enviar para um servidor
        alert("Comentário enviado: " + commentInput);
        document.getElementById("comment-input").value = ''; // Limpa o campo de texto
    } else {
        alert("Por favor, escreva um comentário.");
    }
});

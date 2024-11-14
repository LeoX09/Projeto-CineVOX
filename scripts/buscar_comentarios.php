<?php
// Função para buscar os comentários de um filme
function buscar_comentarios($id_filme) {
    // Conexão com o banco de dados na pasta 'database'
    $db = new PDO('sqlite:../database/usuarios.sqlite'); // Caminho atualizado para o banco de dados
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta SQL para buscar os comentários do filme específico
    $query = "SELECT usuario_nome, data_hora, texto FROM comentarios WHERE id_filme = :id_filme ORDER BY data_hora DESC";
    $stmt = $db->prepare($query);
    
    // Vincula o ID do filme à consulta
    $stmt->bindParam(':id_filme', $id_filme, PDO::PARAM_INT);
    
    // Executa a consulta
    $stmt->execute();
    
    // Retorna os resultados
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

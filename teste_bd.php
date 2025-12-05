<?php
// Ficheiro de teste para verificar a base de dados
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Teste de Conexão à Base de Dados</h2>";

include("bd.php");

// Testar conexão
if ($ms->connect_error) {
    die("❌ Erro de conexão: " . $ms->connect_error);
}
echo "✅ Conexão à BD estabelecida<br><br>";

// Verificar estrutura da tabela categorias
echo "<h3>Estrutura da tabela 'categorias':</h3>";
$result = $ms->query("DESCRIBE categorias");
if ($result) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "</tr>";
    }
    echo "</table><br>";
} else {
    echo "❌ Erro ao ler estrutura: " . $ms->error . "<br>";
}

// Verificar dados na tabela categorias
echo "<h3>Dados na tabela 'categorias':</h3>";
$result = $ms->query("SELECT * FROM categorias LIMIT 5");
if ($result) {
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Nome</th><th>Imagem</th><th>Descrição</th><th>Correspondente</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . ($row['id'] ?? 'N/A') . "</td>";
            echo "<td>" . ($row['nome'] ?? 'N/A') . "</td>";
            echo "<td>" . ($row['imagem'] ?? 'N/A') . "</td>";
            echo "<td>" . ($row['descricao'] ?? 'N/A') . "</td>";
            echo "<td>" . ($row['correspondente'] ?? 'N/A') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "⚠️ Tabela vazia - sem categorias<br>";
    }
} else {
    echo "❌ Erro ao ler dados: " . $ms->error . "<br>";
}

// Verificar estrutura da tabela produtos
echo "<br><h3>Estrutura da tabela 'produtos':</h3>";
$result = $ms->query("DESCRIBE produtos");
if ($result) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Campo</th><th>Tipo</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['Field'] . "</td><td>" . $row['Type'] . "</td></tr>";
    }
    echo "</table>";
}

$ms->close();
echo "<br><h3>✅ Teste concluído!</h3>";
echo "<p><a href='catalogo.php'>← Voltar ao catálogo</a></p>";
?>

<?php
include ("../../bd.php");

header('Content-Type: application/json');

if(isset($_GET['categoria_id']) && !empty($_GET['categoria_id'])){
    $categoria_id = intval($_GET['categoria_id']);
    
    $qr = "SELECT * FROM subcategorias WHERE categoria_id = ? ORDER BY nome";
    $stmt = $ms->prepare($qr);
    $stmt->bind_param('i', $categoria_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $subcategorias = array();
    while($row = $result->fetch_array()){
        $subcategorias[] = array(
            'id' => $row['id'],
            'nome' => $row['nome']
        );
    }
    
    echo json_encode($subcategorias);
    $stmt->close();
} else {
    echo json_encode(array());
}

$ms->close();
?>

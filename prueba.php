<?php
include_once 'conexion.php'; // Tu archivo con el host localhost:3307 [cite: 120]

try {
    // 1. Consultamos los productos y su categoría [cite: 211-217]
    $sql = "SELECT p.*, c.nombre AS cat_nombre 
            FROM PRODUCTO p 
            INNER JOIN CATEGORIA c ON p.id_categoria = c.id_categoria";
    
    $stmt = $pdo->query($sql);
    $productos = $stmt->fetchAll();

    echo "<h1>Catálogo Real de Velvia</h1>";

    foreach ($productos as $producto) {
        echo "<div style='border:1px solid #c58c85; margin:10px; padding:10px; border-radius:8px;'>";
        echo "<h2>" . $producto['nombre'] . " (" . $producto['cat_nombre'] . ")</h2>";
        echo "<p>Precio: <strong>" . $producto['precio'] . "€</strong></p>";
        
        // Aplicamos tu lógica de seguridad para niños/gatos
        if ($producto['seguro_hogar'] == 0) {
            echo "<p style='color:red;'>⚠️ PRECAUCIÓN: Consultar uso con mascotas/niños.</p>";
        } else {
            echo "<p style='color:green;'>✅ Producto seguro para el hogar.</p>";
        }
        
        echo "</div>";
    }

} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}
?>

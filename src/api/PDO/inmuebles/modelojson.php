<?php
require __DIR__ . 'database.php';

class Datos extends Database
{
    private $pdo;
   


    public function createInmuebleModel($datosModel, $tabla) {
        try {
            $sql = "INSERT INTO $tabla (bloque, apto, id_titular) VALUES (:bloque, :apto, :id_titular)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':bloque', $datosModel['bloque']);
            $stmt->bindParam(':apto', $datosModel['apto']);
            $stmt->bindParam(':id_titular', $datosModel['id_titular']);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al insertar inmueble: " . $e->getMessage());
        }
    }
    

    public function readInmuebleModel($tabla, $id_inmueble = null)
    {
        // Construye la consulta SQL para seleccionar los inmuebles
        $sql = "SELECT inmuebles.id_inmueble, inmuebles.bloque, inmuebles.apto, inmuebles.id_titular, personas.nombres, personas.apellidos 
                FROM $tabla 
                LEFT JOIN personas ON inmuebles.id_titular = personas.id_persona";

        // Añade una condición para buscar por id_inmueble si se proporciona
        if ($id_inmueble !== null) {
            $sql .= " WHERE inmuebles.id_inmueble = :id_inmueble";
        }

        // Prepara la consulta SQL
        $stmt = $this->getConnection()->prepare($sql);

        // Vincula el parámetro id_inmueble si se proporciona
        if ($id_inmueble !== null) {
            $stmt->bindParam(":id_inmueble", $id_inmueble, PDO::PARAM_INT);
        }

        // Ejecuta la consulta
        $stmt->execute();

        // Almacena los resultados en un array
        $inmuebles = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row = array_map('utf8_encode', $row); // Codifica los valores a UTF-8
            $inmuebles[] = $row;
        }

        // Retorna el array de inmuebles
        return $inmuebles;
    }

    public function updateInmuebleModel($datosModel, $tabla, $id_inmueble)
    {
        // Prepara la consulta para actualizar un inmueble
        $stmt = $this->getConnection()->prepare("UPDATE $tabla SET bloque = :bloque, apto = :apto, id_titular = :id_titular WHERE id_inmueble = :id_inmueble");
        
        // Vincula los parámetros de la consulta con los datos proporcionados
        $stmt->execute([
            ':bloque' => $datosModel['bloque'],
            ':apto' => $datosModel['apto'],
            ':id_titular' => $datosModel['id_titular'],
            ':id_inmueble' => $id_inmueble
        ]);

        // Retorna verdadero si se afectó alguna fila (actualización exitosa)
        return $stmt->rowCount() > 0;
    }

    public function deleteInmuebleModel($tabla, $id_inmueble)
    {
        // Prepara la consulta para eliminar un inmueble
        $stmt = $this->getConnection()->prepare("DELETE FROM $tabla WHERE id_inmueble = :id_inmueble");
        
        // Vincula el parámetro id_inmueble
        $stmt->bindParam(':id_inmueble', $id_inmueble, PDO::PARAM_INT);
        
        // Ejecuta la consulta
        $stmt->execute();

        // Retorna verdadero si se afectó alguna fila (eliminación exitosa)
        return $stmt->rowCount() > 0;
    }
}

?>

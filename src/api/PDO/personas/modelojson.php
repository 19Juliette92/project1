<?php
require_once 'database.php';

class Datos extends Database
{
    public function createPersonaModel($datosModel, $tabla)
    {
        // Verifica cuántos registros existen con el mismo num_doc
        $stmt = $this->getConnection()->prepare("SELECT COUNT(*) as total FROM $tabla WHERE num_doc = :num_doc");
        $stmt->execute([':num_doc' => $datosModel['num_doc']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si hay menos de 2 registros con el mismo num_doc, permite la inserción
        if ($result['total'] == 0) {
            $stmt = $this->getConnection()->prepare("INSERT INTO $tabla (tipo_persona, tip_doc, num_doc, nombres, apellidos, genero, email, telefono, fecha_creacion, fecha_actualizacion) VALUES (:tipo_persona, :tip_doc, :num_doc, :nombres, :apellidos, :genero, :email, :telefono, NOW(), NOW())");
            $stmt->execute([
                ':tipo_persona' => $datosModel['tipo_persona'],
                ':tip_doc' => $datosModel['tip_doc'],
                ':num_doc' => $datosModel['num_doc'],
                ':nombres' => $datosModel['nombres'],
                ':apellidos' => $datosModel['apellidos'],
                ':genero' => $datosModel['genero'],
                ':email' => $datosModel['email'],
                ':telefono' => $datosModel['telefono']
            ]);

            return $stmt->rowCount() > 0;
        } else {
            // Si ya existen 2 registros con el mismo num_doc, no permite la inserción
            return false;
        }
    }


    public function readPersonaModel($tabla, $num_doc = null)
    {
        // Construye la consulta SQL
        $sql = "SELECT personas.id_persona, personas.tipo_persona, tipos.nombre_tipo, personas.tip_doc, personas.num_doc, personas.nombres, personas.apellidos, personas.genero, personas.email, personas.telefono, personas.fecha_creacion, personas.fecha_actualizacion  
            FROM $tabla
            LEFT JOIN tipos ON personas.tipo_persona = tipos.id_tipo";

        // Añade la condición para buscar por num_doc si se proporciona
        if ($num_doc !== null) {
            $sql .= " WHERE personas.num_doc = :num_doc";
        }

        // Prepara la consulta
        $stmt = $this->getConnection()->prepare($sql);

        // Si se proporciona un num_doc, vincúlalo al parámetro de la consulta
        if ($num_doc !== null) {
            $stmt->bindParam(":num_doc", $num_doc, PDO::PARAM_STR);
        }

        // Ejecuta la consulta
        $stmt->execute();

        // Almacena los resultados en un array
        $personas = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row = array_map('utf8_encode', $row);
            $personas[] = $row;
        }

        // Retorna el array con los resultados
        return $personas;
    }


    public function updatePersonaModel($datosModel, $tabla, $id_persona)
    {

        $stmt = $this->getConnection()->prepare("UPDATE $tabla SET tipo_persona = :tipo_persona, tip_doc = :tip_doc, num_doc = :num_doc, nombres = :nombres, apellidos = :apellidos, genero = :genero, email = :email, telefono = :telefono, fecha_actualizacion = NOW() WHERE id_persona = :id_persona");
        $stmt->execute([
            ':tipo_persona' => $datosModel['tipo_persona'],
            ':tip_doc' => $datosModel['tip_doc'],
            ':num_doc' => $datosModel['num_doc'],
            ':nombres' => $datosModel['nombres'],
            ':apellidos' => $datosModel['apellidos'],
            ':genero' => $datosModel['genero'],
            ':email' => $datosModel['email'],
            ':telefono' => $datosModel['telefono'],
            ':id_persona' => $id_persona
        ]);

        return $stmt->rowCount() > 0;
    }

    public function deletePersonaModel($tabla, $id_persona)
{
    try {
        $this->getConnection()->beginTransaction();

        // Elimina los registros relacionados en la tabla `accesos` que dependen de `vehiculos`
        $stmt = $this->getConnection()->prepare("DELETE FROM accesos WHERE placa IN (SELECT placa FROM vehiculos WHERE id_conductor = :id_persona)");
        $stmt->bindParam(':id_persona', $id_persona, PDO::PARAM_INT);
        $stmt->execute();

        // Elimina los registros relacionados en la tabla `estacionamientos` que dependen de `vehiculos`
        $stmt = $this->getConnection()->prepare("DELETE FROM estacionamientos WHERE placa IN (SELECT placa FROM vehiculos WHERE id_conductor = :id_persona)");
        $stmt->bindParam(':id_persona', $id_persona, PDO::PARAM_INT);
        $stmt->execute();

        // Elimina los registros relacionados en la tabla `accesos` que dependen de `estacionamientos`
        $stmt = $this->getConnection()->prepare("DELETE FROM accesos WHERE id_estacionamiento IN (SELECT id_estacionamiento FROM estacionamientos WHERE id_titular = :id_persona)");
        $stmt->bindParam(':id_persona', $id_persona, PDO::PARAM_INT);
        $stmt->execute();

        // Elimina los registros relacionados en la tabla `accesos` que dependen de `personas`
        $stmt = $this->getConnection()->prepare("DELETE FROM accesos WHERE id_persona = :id_persona");
        $stmt->bindParam(':id_persona', $id_persona, PDO::PARAM_INT);
        $stmt->execute();

        // Elimina los registros relacionados en la tabla `vehiculos`
        $stmt = $this->getConnection()->prepare("DELETE FROM vehiculos WHERE id_conductor = :id_persona");
        $stmt->bindParam(':id_persona', $id_persona, PDO::PARAM_INT);
        $stmt->execute();

        // Obtén todos los id_inmueble asociados con la persona para eliminarlos después de los estacionamientos
        $stmt = $this->getConnection()->prepare("SELECT id_inmueble FROM inmuebles WHERE id_titular = :id_persona");
        $stmt->bindParam(':id_persona', $id_persona, PDO::PARAM_INT);
        $stmt->execute();
        $inmuebles = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Elimina registros relacionados en la tabla `estacionamientos` que dependen de `inmuebles`
        foreach ($inmuebles as $id_inmueble) {
            $stmt = $this->getConnection()->prepare("DELETE FROM estacionamientos WHERE id_inmueble = :id_inmueble");
            $stmt->bindParam(':id_inmueble', $id_inmueble, PDO::PARAM_INT);
            $stmt->execute();
        }

        // Elimina los registros relacionados en la tabla `estacionamientos` que dependen de `personas`
        $stmt = $this->getConnection()->prepare("DELETE FROM estacionamientos WHERE id_titular = :id_persona");
        $stmt->bindParam(':id_persona', $id_persona, PDO::PARAM_INT);
        $stmt->execute();

        // Elimina los registros relacionados en la tabla `inmuebles`
        $stmt = $this->getConnection()->prepare("DELETE FROM inmuebles WHERE id_titular = :id_persona");
        $stmt->bindParam(':id_persona', $id_persona, PDO::PARAM_INT);
        $stmt->execute();

        // Finalmente, elimina el registro de la tabla `personas`
        $stmt = $this->getConnection()->prepare("DELETE FROM $tabla WHERE id_persona = :id_persona");
        $stmt->bindParam(':id_persona', $id_persona, PDO::PARAM_INT);
        $stmt->execute();

        $this->getConnection()->commit();

        return $stmt->rowCount() > 0;
    } catch (Exception $e) {
        $this->getConnection()->rollBack();
        throw $e;
    }
}

}

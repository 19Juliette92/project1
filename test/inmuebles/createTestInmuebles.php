<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/api/PDO/inmuebles/modelojson.php';

class CreateTestInmuebles extends TestCase
{
    private $pdo;
    private $datos;

    protected function setUp(): void
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=intelligate_v2', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->datos = new Datos($this->pdo);
    }

    public function testCreateUniqueInmuebleModel()
    {
        $tabla = 'inmuebles';

        // Contar registros antes de la inserción
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM $tabla");
        $countBefore = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        print "Count before: $countBefore\n"; // Imprimir el conteo antes de la inserción

        // Datos de prueba con un id_titular único
        $datosModel = [
            'bloque' => '4',
            'apto' => '202',
            'id_titular' => '12', // Asegúrate de que este id_titular sea único
        ];

        // Llama al método para insertar el registro
        $result = $this->datos->createInmuebleModel($datosModel, $tabla);

        // Verifica que el método devuelva true
        $this->assertTrue($result, "La inserción del registro falló, registro ya creado.");

        // Obtener el id_inmueble generado automáticamente por la inserción
        $id_inmueble = $this->pdo->lastInsertId();

        // Verifica que el id_inmueble no sea falso o nulo
        $this->assertNotEmpty($id_inmueble, "El id_inmueble generado no es válido.");

        // Preparar la consulta para verificar que los datos se hayan insertado en la base de datos
        $stmt = $this->pdo->prepare("SELECT * FROM $tabla WHERE id_inmueble = :id_inmueble");
        $stmt->execute([':id_inmueble' => $id_inmueble]); // Usa el valor de id_inmueble generado
        $inmueble = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($inmueble, "El registro no se encontró en la base de datos.");
        $this->assertEquals($datosModel['bloque'], $inmueble['bloque']);
        $this->assertEquals($datosModel['apto'], $inmueble['apto']);
        $this->assertEquals($datosModel['id_titular'], $inmueble['id_titular']);

        // Contar registros después de la inserción
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM $tabla");
        $countAfter = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        print "Count after: $countAfter\n"; // Imprimir el conteo después de la inserción

        // Verificar que el conteo haya incrementado en 1
        $this->assertEquals($countBefore + 1, $countAfter, "El número de registros no ha aumentado en 1.");
    }
}

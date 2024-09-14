<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/api/PDO/estacionamientos/modelojson.php';

class CreateTestEstacionamientos extends TestCase
{
    private $pdo;
    private $datos;

    protected function setUp(): void
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=intelligate_v2', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->datos = new Datos($this->pdo);
    }

    public function testCreateUniqueEstacionamientoModel()
    {
        $tabla = 'estacionamientos';

        // Contar registros antes de la inserción
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM $tabla");
        $countBefore = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        print "Count before: $countBefore\n"; // Imprimir el conteo antes de la inserción

        // Datos de prueba con un no_estacionamiento único
        $datosModel = [
            'no_estacionamiento' => '1201',
            'id_titular' => '12',
            'placa' => 'GHI321',
            'id_inmueble' => '12',
            'id_usuario' => '2'
        ];

        // Intento de inserción del primer registro
        $result = $this->datos->createEstacionamientoModel($datosModel, $tabla);
        $this->assertTrue($result, "El primer intento de inserción debería ser exitoso.");

        // Verificar que los datos se hayan insertado en la base de datos
        $stmt = $this->pdo->query("SELECT * FROM $tabla WHERE no_estacionamiento = '1201'");
        $estacionamiento = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($estacionamiento, "El registro no se encontró en la base de datos.");
        $this->assertEquals($datosModel['no_estacionamiento'], $estacionamiento['no_estacionamiento']);
        $this->assertEquals($datosModel['id_titular'], $estacionamiento['id_titular']);
        $this->assertEquals($datosModel['placa'], $estacionamiento['placa']);
        $this->assertEquals($datosModel['id_inmueble'], $estacionamiento['id_inmueble']);
        $this->assertEquals($datosModel['id_usuario'], $estacionamiento['id_usuario']);

        // Contar registros después de la inserción
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM $tabla");
        $countAfter = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        print "Count after: $countAfter\n"; // Imprimir el conteo después de la inserción

        // Verificar que el conteo haya incrementado en 1
        $this->assertEquals($countBefore + 1, $countAfter, "El número de registros no ha aumentado en 1.");

        // Intento de inserción del registro duplicado
        $result = $this->datos->createEstacionamientoModel($datosModel, $tabla);
        $this->assertFalse($result, "El segundo intento de inserción debería fallar debido a un duplicado.");

        // Verificar que el conteo no haya cambiado después del intento de inserción duplicado
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM $tabla");
        $countAfterDuplicate = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        $this->assertEquals($countAfter, $countAfterDuplicate, "El número de registros no debería haber cambiado después del intento de inserción duplicado.");
    }
}


// ./vendor/bin/phpunit --bootstrap vendor/autoload.php test/estacionamientos/CreateTestEstacionamientos.php --colors
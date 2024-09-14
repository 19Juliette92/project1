<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/api/PDO/Vehiculos/modelojson.php';

class CreateTestVehiculos extends TestCase
{
    private $pdo;
    private $datos;

    protected function setUp(): void
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=intelligate_v2', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->datos = new Datos($this->pdo);
    }

    public function testCreateUniqueVehiculoModel()
    {
        $tabla = 'Vehiculos';

        // Contar registros antes de la inserción
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM $tabla");
        $countBefore = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        print "Count before: $countBefore\n"; // Imprimir el conteo antes de la inserción

        // Datos de prueba con un modelo único
        $datosModel = [

            'placa' => 'GHI321',
            'id_conductor' => '14',
            'marca' => 'Nissan',
            'modelo' => '2018',
            'color' => 'Verde',
            'tipo_vehiculo' => 'TV002',

        ];

        // Llama al método para insertar el registro
        $result = $this->datos->createVehiculoModel($datosModel, $tabla);

        // Verifica que el método devuelva true
        $this->assertTrue($result, "La inserción del registro falló, registro ya creado.");

        // Verifica que los datos se hayan insertado en la base de datos
        $stmt = $this->pdo->prepare("SELECT * FROM $tabla WHERE placa = :placa");
        $stmt->execute([':placa' => $datosModel['placa']]);

        $vehiculo = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($vehiculo, "El registro no se encontró en la base de datos.");
        $this->assertEquals($datosModel['id_conductor'], $vehiculo['id_conductor']);
        $this->assertEquals($datosModel['marca'], $vehiculo['marca']);
        $this->assertEquals($datosModel['modelo'], $vehiculo['modelo']);
        $this->assertEquals($datosModel['color'], $vehiculo['color']);

        // Contar registros después de la inserción
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM $tabla");
        $countAfter = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        print "Count after: $countAfter\n"; // Imprimir el conteo después de la inserción

        // Verificar que el conteo haya incrementado en 1
        $this->assertEquals($countBefore + 1, $countAfter, "El número de registros no ha aumentado en 1.");
    }
}

// ./vendor/bin/phpunit --bootstrap vendor/autoload.php test/Vehiculos/CreateTestVehiculos.php --colors
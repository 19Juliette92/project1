<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/api/PDO/vehiculos/modelojson.php'; // Asegúrate de incluir el archivo correcto con la clase modelojson

class UpdateTestVehiculos extends TestCase
{
    private $pdo;
    private $datos;

    protected function setUp(): void
    {
        // Configura la conexión a la base de datos existente
        $this->pdo = new PDO('mysql:host=localhost;dbname=intelligate_v2', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Inicializa la clase Datos (o modelojson)
        $this->datos = new Datos($this->pdo);
    }

    public function testUpdateVehiculoModel()
    {
        $placa = 'XYZ789'; // ID del registro que vamos a modificar

        // Datos actualizados para el registro existente
        $datosActualizados = [
            'placa' => 'XYZ789',
            'id_conductor' => '12',
            'marca' => 'Honda',
            'modelo' => '2019',
            'color' => 'Rojo',
            'tipo_vehiculo' => 'TV001',
        ];  
        $tabla = 'vehiculos';

        // Llama al método para actualizar el registro existente
        $result = $this->datos->updateVehiculoModel($datosActualizados, $tabla, $placa);

        // Verifica que el método devuelva true
        $this->assertTrue($result);

        // Verifica que los datos se hayan actualizado correctamente en la base de datos
        $stmt = $this->pdo->prepare("SELECT * FROM $tabla WHERE placa = :placa");
        $stmt->execute([':placa' => $placa]);
        $vehiculo = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($vehiculo);
        $this->assertEquals($datosActualizados['placa'], $vehiculo['placa']);
        $this->assertEquals($datosActualizados['id_conductor'], $vehiculo['id_conductor']);
        $this->assertEquals($datosActualizados['marca'], $vehiculo['marca']);
        $this->assertEquals($datosActualizados['modelo'], $vehiculo['modelo']);
        $this->assertEquals($datosActualizados['color'], $vehiculo['color']);
        $this->assertEquals($datosActualizados['tipo_vehiculo'], $vehiculo['tipo_vehiculo']);
    }
}
//./vendor/bin/phpunit --bootstrap vendor/autoload.php test/vehiculos/updateTestVehiculos.php --colors
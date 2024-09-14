<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/api/PDO/estacionamientos/modelojson.php'; // Asegúrate de incluir el archivo correcto con la clase modelojson

class UpdateTestEstacionamientos extends TestCase
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

    public function testUpdateEstacionamientoModel()
    {
        $id_estacionamiento = 4; // ID del registro que vamos a modificar

        // Datos actualizados para el registro existente
        $datosActualizados = [
            'no_estacionamiento' => '1002',
            'id_titular' => '10',
            'placa' => 'DEF789', // Asegúrate de que este placa sea único
            'id_inmueble' => '13',
            'id_usuario' => '2'
        ];
        $tabla = 'estacionamientos';

        // Llama al método para actualizar el registro existente
        $result = $this->datos->updateEstacionamientoModel($datosActualizados, $tabla, $id_estacionamiento);

        // Verifica que el método devuelva true
        $this->assertTrue($result);

        // Verifica que los datos se hayan actualizado correctamente en la base de datos
        $stmt = $this->pdo->query("SELECT * FROM $tabla WHERE id_estacionamiento = $id_estacionamiento");
        $estacionamiento = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($estacionamiento);
        $this->assertEquals($datosActualizados['no_estacionamiento'], $estacionamiento['no_estacionamiento']);
        $this->assertEquals($datosActualizados['id_titular'], $estacionamiento['id_titular']);
        $this->assertEquals($datosActualizados['placa'], $estacionamiento['placa']);
        $this->assertEquals($datosActualizados['id_inmueble'], $estacionamiento['id_inmueble']);
        $this->assertEquals($datosActualizados['id_usuario'], $estacionamiento['id_usuario']);
    }
}
//./vendor/bin/phpunit --bootstrap vendor/autoload.php test/estacionamientos/updateTestEstacionamientos.php --colors
<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/api/PDO/inmuebles/modelojson.php'; // Asegúrate de incluir el archivo correcto con la clase modelojson

class UpdateTestInmuebles extends TestCase
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

    public function testUpdateInmuebleModel()
    {
        $id_inmueble = 5; // ID del registro que vamos a modificar

        // Datos actualizados para el registro existente
        $datosActualizados = [
            'bloque' => '5',
            'apto' => '402',
            'id_titular' => '11', 
        ];
        $tabla = 'inmuebles';

        // Llama al método para actualizar el registro existente
        $result = $this->datos->updateInmuebleModel($datosActualizados, $tabla, $id_inmueble);

        // Verifica que el método devuelva true
        $this->assertTrue($result);

        // Verifica que los datos se hayan actualizado correctamente en la base de datos
        $stmt = $this->pdo->query("SELECT * FROM $tabla WHERE id_inmueble = $id_inmueble");
        $inmueble = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($inmueble);
        $this->assertEquals($datosActualizados['bloque'], $inmueble['bloque']);
        $this->assertEquals($datosActualizados['apto'], $inmueble['apto']);
        $this->assertEquals($datosActualizados['id_titular'], $inmueble['id_titular']);
    }
}
//./vendor/bin/phpunit --bootstrap vendor/autoload.php test/inmuebles/updateTestInmuebles.php --colors
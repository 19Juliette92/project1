<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/api/PDO/personas/modelojson.php';

class pruebasSolas extends TestCase
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

    public function testCreateInmuebleModel() // Cambiado el nombre del método
    {
        // Nuevos datos de prueba para un nuevo inmueble
        $datosModel = [
            'bloque' => 5,  // Cambiar a un valor único
            'apto' => 404,  // Cambiar a un valor único
            'id_titular' => 6 // Asegúrate de que este ID de titular exista en la tabla 'personas'
        ];
        $tabla = 'inmuebles';

        try {
            // Llama al método para insertar el registro
            $result = $this->datos->createInmuebleModel($datosModel, $tabla);

            // Verifica que el método devuelva true
            $this->assertTrue($result, "La inserción del inmueble no devolvió true");

            // Verifica que los datos se hayan insertado en la base de datos
            $stmt = $this->pdo->query("SELECT * FROM $tabla WHERE bloque = 4 AND apto = 404");
            $inmueble = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->assertNotFalse($inmueble, "No se encontraron registros para el nuevo inmueble");
            $this->assertEquals($datosModel['bloque'], $inmueble['bloque']);
            $this->assertEquals($datosModel['apto'], $inmueble['apto']);
            $this->assertEquals($datosModel['id_titular'], $inmueble['id_titular']);
        } catch (Exception $e) {
            $this->fail("Excepción al crear o verificar el inmueble: " . $e->getMessage());
        }
    }
}

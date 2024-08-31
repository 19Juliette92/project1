<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/api/PDO/personas/modelojson.php'; // Asegúrate de incluir el archivo correcto con la clase modelojson

class CreateTestPersonas extends TestCase
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

    public function testCreateUniquePersonaModel()
    {
        // Datos de prueba con un num_doc único
        $datosModel = [
            'tipo_persona' => 'TP002',
            'tip_doc' => 'NIT',
            'num_doc' => '8876543210',  // Un num_doc que no está presente en la base de datos
            'nombres' => 'Camilo',
            'apellidos' => 'Rojas',
            'genero' => 'Masculino',
            'email' => 'camilo@example.com',
            'telefono' => '3216549870'
        ];
        $tabla = 'personas';

        // Llama al método para insertar el registro
        $result = $this->datos->createPersonaModel($datosModel, $tabla);

        // Verifica que el método devuelva true
        $this->assertTrue($result);

        // Verifica que los datos se hayan insertado en la base de datos
        $stmt = $this->pdo->query("SELECT * FROM $tabla WHERE num_doc = '8876543210'");
        $persona = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($persona);
        $this->assertEquals($datosModel['tipo_persona'], $persona['tipo_persona']);
        $this->assertEquals($datosModel['tip_doc'], $persona['tip_doc']);
        $this->assertEquals($datosModel['num_doc'], $persona['num_doc']);
        $this->assertEquals($datosModel['nombres'], $persona['nombres']);
        $this->assertEquals($datosModel['apellidos'], $persona['apellidos']);
        $this->assertEquals($datosModel['genero'], $persona['genero']);
        $this->assertEquals($datosModel['email'], $persona['email']);
        $this->assertEquals($datosModel['telefono'], $persona['telefono']);
    }
}
// ./vendor/bin/phpunit --bootstrap vendor/autoload.php test/personas/createTestPersonas.php --colors
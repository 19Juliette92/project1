<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/api/PDO/personas/modelojson.php';

class CreateTestPersonas extends TestCase
{
    private $pdo;
    private $datos;

    protected function setUp(): void
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=intelligate_v2', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->datos = new Datos($this->pdo);
    }

    public function testCreateUniquePersonaModel()
    {
        $tabla = 'personas';

        // Contar registros antes de la inserción
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM $tabla");
        $countBefore = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        print "Count before: $countBefore\n"; // Imprimir el conteo antes de la inserción

        // Datos de prueba con un num_doc único
        $datosModel = [
            'tipo_persona' => 'TP003',
            'tip_doc' => 'CE',
            'num_doc' => '963741852', // Asegúrate de que este num_doc sea único
            'nombres' => 'María',
            'apellidos' => 'González',
            'genero' => 'Femenino',
            'email' => 'maria@example.com',
            'telefono' => '3124567890'
        ];

        // Llama al método para insertar el registro
        $result = $this->datos->createPersonaModel($datosModel, $tabla);

        // Verifica que el método devuelva true
        $this->assertTrue($result, "La inserción del registro falló, registro ya creado.");

        // Verifica que los datos se hayan insertado en la base de datos
        $stmt = $this->pdo->query("SELECT * FROM $tabla WHERE num_doc = '963741852'");
        $persona = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($persona, "El registro no se encontró en la base de datos.");
        $this->assertEquals($datosModel['tipo_persona'], $persona['tipo_persona']);
        $this->assertEquals($datosModel['tip_doc'], $persona['tip_doc']);
        $this->assertEquals($datosModel['num_doc'], $persona['num_doc']);
        $this->assertEquals($datosModel['nombres'], $persona['nombres']);
        $this->assertEquals($datosModel['apellidos'], $persona['apellidos']);
        $this->assertEquals($datosModel['genero'], $persona['genero']);
        $this->assertEquals($datosModel['email'], $persona['email']);
        $this->assertEquals($datosModel['telefono'], $persona['telefono']);

        // Contar registros después de la inserción
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM $tabla");
        $countAfter = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        print "Count after: $countAfter\n"; // Imprimir el conteo después de la inserción

        // Verificar que el conteo haya incrementado en 1
        $this->assertEquals($countBefore + 1, $countAfter, "El número de registros no ha aumentado en 1.");
    }
}

// ./vendor/bin/phpunit --bootstrap vendor/autoload.php test/personas/CreateTestPersonas.php --colors
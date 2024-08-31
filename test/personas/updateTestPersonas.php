<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/api/PDO/personas/modelojson.php'; // Asegúrate de incluir el archivo correcto con la clase modelojson

class UpdateTestPersonas extends TestCase
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

    public function testUpdatePersonaModel()
    {
        $id_persona = 2; // ID del registro que vamos a modificar

        // Datos actualizados para el registro existente
        $datosActualizados = [
            'tipo_persona' => 'TP001',
            'tip_doc' => 'CC',
            'num_doc' => '1234567890',  // Nuevo num_doc
            'nombres' => 'Carlos Andres',
            'apellidos' => 'Gomez Mejia',
            'genero' => 'Masculino',
            'email' => 'carlos.andres@example.com',
            'telefono' => '3109876543'
        ];
        $tabla = 'personas';

        // Llama al método para actualizar el registro existente
        $result = $this->datos->updatePersonaModel($datosActualizados, $tabla, $id_persona);

        // Verifica que el método devuelva true
        $this->assertTrue($result);

        // Verifica que los datos se hayan actualizado correctamente en la base de datos
        $stmt = $this->pdo->query("SELECT * FROM $tabla WHERE id_persona = $id_persona");
        $persona = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($persona);
        $this->assertEquals($datosActualizados['tipo_persona'], $persona['tipo_persona']);
        $this->assertEquals($datosActualizados['tip_doc'], $persona['tip_doc']);
        $this->assertEquals($datosActualizados['num_doc'], $persona['num_doc']);
        $this->assertEquals($datosActualizados['nombres'], $persona['nombres']);
        $this->assertEquals($datosActualizados['apellidos'], $persona['apellidos']);
        $this->assertEquals($datosActualizados['genero'], $persona['genero']);
        $this->assertEquals($datosActualizados['email'], $persona['email']);
        $this->assertEquals($datosActualizados['telefono'], $persona['telefono']);
    }
}
//./vendor/bin/phpunit --bootstrap vendor/autoload.php test/personas/updateTestPersonas.php --colors
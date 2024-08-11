<?php

use PHPUnit\Framework\TestCase;

require_once './PDO/personas/modelojson.php'; // Asegúrate de incluir el archivo correcto con la clase modelojson

class DeleteTestPersonas extends TestCase
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

    public function testDeletePersonaModel()
    {
        // Datos de prueba para insertar un nuevo registro
        $datosModel = [
            'tipo_persona' => 'TP003',
            'tip_doc' => 'CC',
            'num_doc' => '1234567890',
            'nombres' => 'Carlos',
            'apellidos' => 'Lopez',
            'genero' => 'M',
            'email' => 'carlos.lopez@example.com',
            'telefono' => '3001234567'
        ];
        $tabla = 'personas';

        // Inserta un nuevo registro
        $this->datos->createPersonaModel($datosModel, $tabla);

        // Obtiene el ID del registro recién insertado
        $stmt = $this->pdo->query("SELECT id_persona FROM $tabla WHERE num_doc = '1234567890'");
        $persona = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_persona = $persona['id_persona'];

        // Verifica que el registro existe antes de la eliminación
        $this->assertNotFalse($persona);

        // Llama al método para eliminar el registro
        $result = $this->datos->deletePersonaModel($tabla, $id_persona);

        // Verifica que el método devuelva true
        $this->assertTrue($result);

        // Verifica que el registro ya no exista en la base de datos
        $stmt = $this->pdo->query("SELECT * FROM $tabla WHERE id_persona = $id_persona");
        $personaEliminada = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica que la consulta no haya devuelto ningún registro
        $this->assertFalse($personaEliminada);
    }
}

// ./vendor/bin/phpunit --bootstrap vendor/autoload.php test/deleteTestPersonas.php --colors


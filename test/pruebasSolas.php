<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/api/PDO/personas/modelojson.php'; // Asegúrate de incluir el archivo correcto con la clase modelojson

class pruebasSolas extends TestCase
{
    private $pdo;
    private $datos;
    private $id_persona_existente = 4; // Cambia este valor por un ID que sepas que existe en tu base de datos

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
        $tabla = 'personas';

        // Verifica que el registro existe antes de la eliminación
        $stmt = $this->pdo->prepare("SELECT * FROM $tabla WHERE id_persona = :id_persona");
        $stmt->execute([':id_persona' => $this->id_persona_existente]);
        $persona = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->assertNotFalse($persona, "El registro con id_persona {$this->id_persona_existente} no existe.");

        // Llama al método para eliminar el registro
        $result = $this->datos->deletePersonaModel($tabla, $this->id_persona_existente);

        // Verifica que el método devuelva true
        $this->assertTrue($result, "No se pudo eliminar el registro con id_persona {$this->id_persona_existente}.");

        // Verifica que el registro ya no exista en la base de datos
        $stmt = $this->pdo->prepare("SELECT * FROM $tabla WHERE id_persona = :id_persona");
        $stmt->execute([':id_persona' => $this->id_persona_existente]);
        $personaEliminada = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica que la consulta no haya devuelto ningún registro
        $this->assertFalse($personaEliminada, "El registro con id_persona {$this->id_persona_existente} todavía existe.");
    }
}

// Ejecuta la prueba con: ./vendor/bin/phpunit --bootstrap vendor/autoload.php test/personas/deleteTestPersonas.php --colors

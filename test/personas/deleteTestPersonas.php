<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/api/PDO/personas/modelojson.php'; // Incluye el archivo con la clase modelojson

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
        $this->datos = new Datos($this->pdo); // Reemplaza con la clase correcta si es necesario
    }

    public function testDeletePersonaModel()
    {
        $tabla = 'personas';
        $id_persona = 4; // Reemplaza con un ID válido de tu base de datos para la prueba

        // Realiza un COUNT de registros antes de la eliminación
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM $tabla");
        $stmt->execute();
        $countBefore = $stmt->fetchColumn();

        // Muestra en pantalla el conteo antes de la eliminación
        print_r("Count before deletion: " . $countBefore . "\n");

        // Verifica que el registro existe antes de la eliminación
        $stmt = $this->pdo->prepare("SELECT * FROM $tabla WHERE id_persona = :id_persona");
        $stmt->execute([':id_persona' => $id_persona]);
        $persona = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->assertNotFalse($persona, "El registro con id_persona $id_persona debería existir antes de la eliminación");

        // Llama al método para eliminar el registro
        $result = $this->datos->deletePersonaModel($tabla, $id_persona);

        // Verifica que el método devuelva true
        $this->assertTrue($result, "La eliminación debería ser exitosa");

        // Realiza un COUNT de registros después de la eliminación
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM $tabla");
        $stmt->execute();
        $countAfter = $stmt->fetchColumn();

        // Muestra en pantalla el conteo después de la eliminación
        print_r("Count after deletion: " . $countAfter . "\n");

        // Asegúrate de que el número de registros se ha reducido en 1
        $this->assertEquals($countBefore - 1, $countAfter, "El conteo de registros debería reducirse en 1 después de la eliminación");

        // Verifica que el registro ya no exista en la base de datos
        $stmt = $this->pdo->prepare("SELECT * FROM $tabla WHERE id_persona = :id_persona");
        $stmt->execute([':id_persona' => $id_persona]);
        $personaEliminada = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica que la consulta no haya devuelto ningún registro
        $this->assertFalse($personaEliminada, "El registro con id_persona $id_persona no debería existir después de la eliminación");
    }
}

// Ejecuta esta prueba con: ./vendor/bin/phpunit --bootstrap vendor/autoload.php test/personas/DeleteTestPersonas.php --colors

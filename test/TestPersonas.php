<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/api/PDO/personas/modelojson.php'; // Incluye el archivo con la clase modelojson

class TestPersonas extends TestCase
{
    private $pdo;
    private $datos;

    protected function setUp(): void
    {
        // Configura la conexión a la base de datos existente
        $this->pdo = new PDO('mysql:host=localhost;dbname=intelligate_v2', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->datos = new Datos($this->pdo);
    }

    // 1. Create
    public function testCreateUniquePersonaModel()
    {
        $tabla = 'personas';

        // Contar registros antes de la inserción
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM $tabla");
        $countBefore = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        print "Count before: $countBefore\n"; // Imprimir el conteo antes de la inserción

        // Datos de prueba con un num_doc único
        $datosModel = [
            'tipo_persona' => 'TP001',
            'tip_doc' => 'CC',
            'num_doc' => '1597852369', // Asegúrate de que este num_doc sea único
            'nombres' => 'Geraldine',
            'apellidos' => 'Salazar',
            'genero' => 'Femenino',
            'email' => 'geraldine@example.com',
            'telefono' => '3018888888'
        ];

        // Llama al método para insertar el registro
        $result = $this->datos->createPersonaModel($datosModel, $tabla);

        // Verifica que el método devuelva true
        $this->assertTrue($result, "La inserción del registro falló, registro ya creado.");
        print "Test Create Unique Persona Model: " . ($result ? "PASSED" : "FAILED") . "\n";

        // Verifica que los datos se hayan insertado en la base de datos
        $stmt = $this->pdo->query("SELECT * FROM $tabla WHERE num_doc = '1597852369'");
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

    // 2. Read
    public function testReadPersonaModelByNumDoc()
    {
        $num_doc = '1597852369';
        $tabla = 'personas';

        // Llama al método para leer el registro con el num_doc específico
        $result = $this->datos->readPersonaModel($tabla, $num_doc); // Pasar $num_doc aquí

        // Verifica que el método devuelva un array y que contenga el registro correcto
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        print "Test Read Persona Model by NumDoc: " . (!empty($result) ? "PASSED" : "FAILED") . "\n";

        // Busca el registro con el num_doc especificado en los resultados
        $found = false;
        foreach ($result as $persona) {
            if ($persona['num_doc'] === $num_doc) {
                $found = true;
                var_dump($persona);

                // Verifica que los datos sean correctos
                $this->assertEquals('TP001', $persona['tipo_persona']);
                $this->assertEquals('CC', $persona['tip_doc']);
                $this->assertEquals($num_doc, $persona['num_doc']);
                $this->assertEquals('Geraldine', $persona['nombres']);
                $this->assertEquals('Salazar', $persona['apellidos']);
                $this->assertEquals('Femenino', $persona['genero']);
                $this->assertEquals('geraldine@example.com', $persona['email']);
                $this->assertEquals('3018888888', $persona['telefono']);
                break;
            }
        }

        // Verifica que el registro haya sido encontrado
        $this->assertTrue($found);
    }

    // 3. Update
    public function testUpdatePersonaModel()
    {
        $id_persona = 5; // ID del registro que vamos a modificar

        // Datos actualizados para el registro existente
        $datosActualizados = [
            'tipo_persona' => 'TP001',
            'tip_doc' => 'CC',
            'num_doc' => '1597852369', // Asegúrate de que este num_doc sea único
            'nombres' => 'Geraldine',
            'apellidos' => 'Salazar',
            'genero' => 'Femenino',
            'email' => 'geraldine11@example.com',
            'telefono' => '3018888888'
        ];
        $tabla = 'personas';

        // Llama al método para actualizar el registro existente
        $result = $this->datos->updatePersonaModel($datosActualizados, $tabla, $id_persona);

        // Verifica que el método devuelva true
        $this->assertTrue($result);
        print "Test Update Persona Model: " . ($result ? "PASSED" : "FAILED") . "\n";

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

    // 4. Delete
    public function testDeletePersonaModel()
    {
        $tabla = 'personas';
        $id_persona = 5; // Reemplaza con un ID válido de tu base de datos para la prueba

        // Realiza un COUNT de registros antes de la eliminación
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM $tabla");
        $stmt->execute();
        $countBefore = $stmt->fetchColumn();
        print "Count before deletion: $countBefore\n";

        // Verifica que el registro existe antes de la eliminación
        $stmt = $this->pdo->prepare("SELECT * FROM $tabla WHERE id_persona = :id_persona");
        $stmt->execute([':id_persona' => $id_persona]);
        $persona = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->assertNotFalse($persona, "El registro con id_persona $id_persona debería existir antes de la eliminación");

        // Llama al método para eliminar el registro
        $result = $this->datos->deletePersonaModel($tabla, $id_persona);

        // Verifica que el método devuelva true
        $this->assertTrue($result, "La eliminación debería ser exitosa");
        print "Test Delete Persona Model: " . ($result ? "PASSED" : "FAILED") . "\n";

        // Realiza un COUNT de registros después de la eliminación
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM $tabla");
        $stmt->execute();
        $countAfter = $stmt->fetchColumn();
        print "Count after deletion: $countAfter\n";

        // Asegúrate de que el número de registros se ha reducido en 1
        $this->assertEquals($countBefore - 1, $countAfter, "El conteo de registros debería reducirse en 1 después de la eliminación");
    }
}

// ./vendor/bin/phpunit --bootstrap vendor/autoload.php test/TestPersonas.php --colors
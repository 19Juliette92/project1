<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/api/PDO/inmuebles/modelojson.php'; // Asegúrate de incluir el archivo correcto con la clase modelojson

class TestInmuebles extends TestCase
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

    public function testCreateUniqueInmuebleModel()
    {
        $tabla = 'inmuebles';

        // Contar registros antes de la inserción
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM $tabla");
        $countBefore = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        print "Count before: $countBefore\n"; // Imprimir el conteo antes de la inserción

        // Datos de prueba con un id_titular único
        $datosModel = [
            'bloque' => '11',
            'apto' => '303',
            'id_titular' => '12', // Asegúrate de que este id_titular sea único
        ];

        // Llama al método para insertar el registro
        $result = $this->datos->createInmuebleModel($datosModel, $tabla);

        // Verifica que el método devuelva true
        $this->assertTrue($result, "La inserción del registro falló, registro ya creado.");

        // Preparar la consulta para verificar que los datos se hayan insertado en la base de datos
        $stmt = $this->pdo->prepare("SELECT * FROM $tabla WHERE id_titular = :id_titular");
        $stmt->execute([':id_titular' => $datosModel['id_titular']]);
        $inmueble = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($inmueble, "El registro no se encontró en la base de datos.");
        $this->assertEquals($datosModel['bloque'], $inmueble['bloque']);
        $this->assertEquals($datosModel['apto'], $inmueble['apto']);
        $this->assertEquals($datosModel['id_titular'], $inmueble['id_titular']);

        // Contar registros después de la inserción
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM $tabla");
        $countAfter = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        print "Count after: $countAfter\n"; // Imprimir el conteo después de la inserción

        // Verificar que el conteo haya incrementado en 1
        $this->assertEquals($countBefore + 1, $countAfter, "El número de registros no ha aumentado en 1.");
    }

    public function testReadInmuebleModelByNumDoc()
    {
        $id_inmueble = '6';
        $tabla = 'inmuebles';

        // Llama al método para leer el registro con el id_inmueble específico
        $result = $this->datos->readInmuebleModel($tabla, $id_inmueble);

        // Verifica que el método devuelva un array y que contenga el registro correcto
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);

        // Busca el registro con el id_inmueble especificado en los resultados
        $found = false;
        foreach ($result as $inmueble) {
            if ($inmueble['id_inmueble'] === $id_inmueble) {
                $found = true;

                // Depuración: Muestra los datos recuperados
                var_dump($inmueble);

                // Verifica que los datos sean correctos
                $this->assertEquals('11', $inmueble['bloque']);
                $this->assertEquals('403', $inmueble['apto']);
                $this->assertEquals('11', $inmueble['id_titular']);
                break;
            }
        }

        // Verifica que el registro haya sido encontrado
        $this->assertTrue($found);
    }

    public function testUpdateInmuebleModel()
    {
        $id_inmueble = 6; // ID del registro que vamos a modificar

        // Datos actualizados para el registro existente
        $datosActualizados = [
            'bloque' => '11',
            'apto' => '101',
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

    public function testDeleteInmuebleModel()
    {
        $tabla = 'inmuebles';
        $id_inmueble = 9; // Reemplaza con un ID válido de tu base de datos para la prueba

        // Realiza un COUNT de registros antes de la eliminación
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM $tabla");
        $stmt->execute();
        $countBefore = $stmt->fetchColumn();

        // Muestra en pantalla el conteo antes de la eliminación
        print_r("Count before deletion: " . $countBefore . "\n");

        // Verifica que el registro existe antes de la eliminación
        $stmt = $this->pdo->prepare("SELECT * FROM $tabla WHERE id_inmueble = :id_inmueble");
        $stmt->execute([':id_inmueble' => $id_inmueble]);
        $inmueble = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->assertNotFalse($inmueble, "El registro con id_inmueble $id_inmueble debería existir antes de la eliminación");

        // Llama al método para eliminar el registro
        $result = $this->datos->deleteInmuebleModel($tabla, $id_inmueble);

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
        $stmt = $this->pdo->prepare("SELECT * FROM $tabla WHERE id_inmueble = :id_inmueble");
        $stmt->execute([':id_inmueble' => $id_inmueble]);
        $inmuebleEliminado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica que la consulta no haya devuelto ningún registro
        $this->assertFalse($inmuebleEliminado, "El registro con id_inmueble $id_inmueble no debería existir después de la eliminación");
    }
}

//Ejecutar pruebas con: ./vendor/bin/phpunit --bootstrap vendor/autoload.php test/TestInmuebles.php --colors
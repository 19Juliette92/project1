<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/api/PDO/estacionamientos/modelojson.php';

class TestEstacionamientos extends TestCase {
    private $pdo;
    private $datos;

    protected function setUp(): void {
        $this->pdo = new PDO('mysql:host=localhost;dbname=intelligate_v2', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->datos = new Datos($this->pdo);
    }

    public function testCreateUniqueEstacionamientoModel() {
        $tabla = 'estacionamientos';

        // Contar registros antes de la inserción
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM $tabla");
        $countBefore = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        print "Count before: $countBefore\n"; // Imprimir el conteo antes de la inserción

        // Datos de prueba con un no_estacionamiento único
        $datosModel = [
            'no_estacionamiento' => '1202',
            'id_titular' => '12',
            'placa' => 'GHI321',
            'id_inmueble' => '12',
            'id_usuario' => '2'
        ];

        // Intento de inserción del primer registro
        $result = $this->datos->createEstacionamientoModel($datosModel, $tabla);
        $this->assertTrue($result, "El primer intento de inserción debería ser exitoso.");

        // Verificar que los datos se hayan insertado en la base de datos
        $stmt = $this->pdo->query("SELECT * FROM $tabla WHERE no_estacionamiento = '1202'");
        $estacionamiento = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($estacionamiento, "El registro no se encontró en la base de datos.");
        $this->assertEquals($datosModel['no_estacionamiento'], $estacionamiento['no_estacionamiento']);
        $this->assertEquals($datosModel['id_titular'], $estacionamiento['id_titular']);
        $this->assertEquals($datosModel['placa'], $estacionamiento['placa']);
        $this->assertEquals($datosModel['id_inmueble'], $estacionamiento['id_inmueble']);
        $this->assertEquals($datosModel['id_usuario'], $estacionamiento['id_usuario']);

        // Contar registros después de la inserción
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM $tabla");
        $countAfter = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        print "Count after: $countAfter\n"; // Imprimir el conteo después de la inserción

        // Verificar que el conteo haya incrementado en 1
        $this->assertEquals($countBefore + 1, $countAfter, "El número de registros no ha aumentado en 1.");

        // Intento de inserción del registro duplicado
        $result = $this->datos->createEstacionamientoModel($datosModel, $tabla);
        $this->assertFalse($result, "El segundo intento de inserción debería fallar debido a un duplicado.");

        // Verificar que el conteo no haya cambiado después del intento de inserción duplicado
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM $tabla");
        $countAfterDuplicate = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        $this->assertEquals($countAfter, $countAfterDuplicate, "El número de registros no debería haber cambiado después del intento de inserción duplicado.");
    }

    public function testReadEstacionamientoModelByNumDoc() {
        $no_estacionamiento = '1101'; 
        $tabla = 'estacionamientos';

        $result = $this->datos->readEstacionamientoModel($tabla, $no_estacionamiento); 
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);

        $found = false;
        foreach ($result as $estacionamiento) {
            if ($estacionamiento['no_estacionamiento'] === $no_estacionamiento) {
                $found = true;

                var_dump($estacionamiento); 

                $this->assertEquals($no_estacionamiento, $estacionamiento['no_estacionamiento']);
                $this->assertEquals('11', $estacionamiento['id_titular']);
                $this->assertEquals('LOU258', $estacionamiento['placa']);
                $this->assertEquals('6', $estacionamiento['id_inmueble']);
                $this->assertEquals('2', $estacionamiento['id_usuario']);
                break;
            }
        }

        $this->assertTrue($found);
    }

    public function testUpdateEstacionamientoModel() {
        $id_estacionamiento = 9; 

        $datosActualizados = [
            'no_estacionamiento' => '1301',
            'id_titular' => '14',
            'placa' => 'GHI321',
            'id_inmueble' => '13',
            'id_usuario' => '2'
        ];
        $tabla = 'estacionamientos';

        $result = $this->datos->updateEstacionamientoModel($datosActualizados, $tabla, $id_estacionamiento);
        $this->assertTrue($result);

        $stmt = $this->pdo->query("SELECT * FROM $tabla WHERE id_estacionamiento = $id_estacionamiento");
        $estacionamiento = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($estacionamiento);
        $this->assertEquals($datosActualizados['no_estacionamiento'], $estacionamiento['no_estacionamiento']);
        $this->assertEquals($datosActualizados['id_titular'], $estacionamiento['id_titular']);
        $this->assertEquals($datosActualizados['placa'], $estacionamiento['placa']);
        $this->assertEquals($datosActualizados['id_inmueble'], $estacionamiento['id_inmueble']);
        $this->assertEquals($datosActualizados['id_usuario'], $estacionamiento['id_usuario']);
    }

    public function testDeleteEstacionamientoModel() {
        $tabla = 'estacionamientos';
        $id_estacionamiento = 17;

        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM $tabla");
        $stmt->execute();
        $countBefore = $stmt->fetchColumn();

        print_r("Count before deletion: " . $countBefore . "\n");

        $stmt = $this->pdo->prepare("SELECT * FROM $tabla WHERE id_estacionamiento = :id_estacionamiento");
        $stmt->execute([':id_estacionamiento' => $id_estacionamiento]);
        $estacionamiento = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->assertNotFalse($estacionamiento, "El registro con id_estacionamiento $id_estacionamiento debería existir antes de la eliminación");

        $result = $this->datos->deleteEstacionamientoModel($tabla, $id_estacionamiento);
        $this->assertTrue($result, "La eliminación debería ser exitosa");

        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM $tabla");
        $stmt->execute();
        $countAfter = $stmt->fetchColumn();

        print_r("Count after deletion: " . $countAfter . "\n");

        $this->assertEquals($countBefore - 1, $countAfter, "El conteo de registros debería reducirse en 1 después de la eliminación");

        $stmt = $this->pdo->prepare("SELECT * FROM $tabla WHERE id_estacionamiento = :id_estacionamiento");
        $stmt->execute([':id_estacionamiento' => $id_estacionamiento]);
        $estacionamientoEliminada = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertFalse($estacionamientoEliminada, "El registro con id_estacionamiento $id_estacionamiento no debería existir después de la eliminación");
    }
}

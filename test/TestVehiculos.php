<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/api/PDO/vehiculos/modelojson.php'; // Asegúrate de incluir el archivo correcto con la clase modelojson

class TestVehiculos extends TestCase
{
    private $pdo;
    private $datos;

    protected function setUp(): void
    {
        // Configura la conexión a la base de datos existente
        $this->pdo = new PDO('mysql:host=localhost;dbname=intelligate_v2;charset=utf8', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Inicializa la clase Datos (o modelojson)
        $this->datos = new Datos($this->pdo);
    }

    public function testCreateUniqueVehiculoModel()
    {
        $tabla = 'vehiculos';

        // Contar registros antes de la inserción
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM $tabla");
        $countBefore = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        print "Count before: $countBefore\n"; // Imprimir el conteo antes de la inserción

        // Datos de prueba con un modelo único
        $datosModel = [

            'placa' => 'MNO456',
            'id_conductor' => '11',
            'marca' => 'Honda',
            'modelo' => '2023',
            'color' => 'Negro',
            'tipo_vehiculo' => 'TV003',

        ];

        // Llama al método para insertar el registro
        $result = $this->datos->createVehiculoModel($datosModel, $tabla);

        // Verifica que el método devuelva true
        $this->assertTrue($result, "La inserción del registro falló.");

        // Verifica que los datos se hayan insertado en la base de datos
        $stmt = $this->pdo->prepare("SELECT * FROM $tabla WHERE placa = :placa");
        $stmt->execute([':placa' => $datosModel['placa']]);
        $vehiculo = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($vehiculo, "El registro no se encontró en la base de datos.");
        $this->assertEquals($datosModel['id_conductor'], $vehiculo['id_conductor']);
        $this->assertEquals($datosModel['marca'], $vehiculo['marca']);
        $this->assertEquals($datosModel['modelo'], $vehiculo['modelo']);
        $this->assertEquals($datosModel['color'], $vehiculo['color']);

        // Contar registros después de la inserción
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM $tabla");
        $countAfter = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        print "Count after: $countAfter\n"; // Imprimir el conteo después de la inserción

        // Verificar que el conteo haya incrementado en 1
        $this->assertEquals($countBefore + 1, $countAfter, "El número de registros no ha aumentado en 1.");
    }

    public function testReadVehiculoModelByNumDoc()
    {
        // El número de documento que queremos leer
        $placa = 'LOU258';

        $tabla = 'vehiculos';

        // Llama al método para leer el registro con el placa específico
        $result = $this->datos->readVehiculoModel($tabla, $placa);

        // Verifica que el método devuelva un array y que contenga el registro correcto
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);

        // Busca el registro con el placa especificado en los resultados
        $found = false;
        foreach ($result as $vehiculo) {
            if ($vehiculo['placa'] === $placa) {
                $found = true;

                // Depuración: Muestra los datos recuperados
                var_dump($vehiculo);

                // Verifica que los datos sean correctos
                $this->assertEquals($placa, $vehiculo['placa']);
                $this->assertEquals('12', $vehiculo['id_conductor']);
                $this->assertEquals('Honda', $vehiculo['marca']);
                $this->assertEquals('2019', $vehiculo['modelo']);
                $this->assertEquals('Blanco', $vehiculo['color']);
                $this->assertEquals('TV003', $vehiculo['tipo_vehiculo']);
                break;
            }
        }

        // Verifica que el registro haya sido encontrado
        $this->assertTrue($found);
    }

    public function testUpdateVehiculoModel()
    {
        $placa = 'XYZ789'; // ID del registro que vamos a modificar

        // Datos actualizados para el registro existente
        $datosActualizados = [
            'placa' => 'XYZ789',
            'id_conductor' => '11',
            'marca' => 'Renault',
            'modelo' => '2021',
            'color' => 'Azul',
            'tipo_vehiculo' => 'TV001',
        ];
        $tabla = 'vehiculos';

        // Llama al método para actualizar el registro existente
        $result = $this->datos->updateVehiculoModel($datosActualizados, $tabla, $placa);

        // Verifica que el método devuelva true
        $this->assertTrue($result);

        // Verifica que los datos se hayan actualizado correctamente en la base de datos
        $stmt = $this->pdo->prepare("SELECT * FROM $tabla WHERE placa = :placa");
        $stmt->execute([':placa' => $placa]);
        $vehiculo = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotFalse($vehiculo);
        $this->assertEquals($datosActualizados['placa'], $vehiculo['placa']);
        $this->assertEquals($datosActualizados['id_conductor'], $vehiculo['id_conductor']);
        $this->assertEquals($datosActualizados['marca'], $vehiculo['marca']);
        $this->assertEquals($datosActualizados['modelo'], $vehiculo['modelo']);
        $this->assertEquals($datosActualizados['color'], $vehiculo['color']);
        $this->assertEquals($datosActualizados['tipo_vehiculo'], $vehiculo['tipo_vehiculo']);
    }

    public function testDeleteVehiculoModel()
    {
        $tabla = 'vehiculos';
        $placa = 'MNO456'; // Reemplaza con placa válida de tu base de datos para la prueba

        // Realiza un COUNT de registros antes de la eliminación
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM $tabla");
        $stmt->execute();
        $countBefore = $stmt->fetchColumn();
        print_r("Count before deletion: " . $countBefore . "\n");

        // Verifica que el registro existe antes de la eliminación
        $stmt = $this->pdo->prepare("SELECT * FROM $tabla WHERE placa = :placa");
        $stmt->execute([':placa' => $placa]);
        $vehiculo = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->assertNotFalse($vehiculo, "El registro con placa $placa debería existir antes de la eliminación");

        // Llama al método para eliminar el registro
        $result = $this->datos->deleteVehiculoModel($tabla, $placa);

        // Verifica que el método devuelva true
        $this->assertTrue($result, "La eliminación debería ser exitosa");

        // Realiza un COUNT de registros después de la eliminación
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM $tabla");
        $stmt->execute();
        $countAfter = $stmt->fetchColumn();
        print_r("Count after deletion: " . $countAfter . "\n");

        // Asegúrate de que el número de registros se ha reducido en 1
        $this->assertEquals($countBefore - 1, $countAfter, "El conteo de registros debería reducirse en 1 después de la eliminación");

        // Verifica que el registro ya no exista en la base de datos
        $stmt = $this->pdo->prepare("SELECT * FROM $tabla WHERE placa = :placa");
        $stmt->execute([':placa' => $placa]);
        $vehiculoEliminado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica que la consulta no haya devuelto ningún registro
        $this->assertFalse($vehiculoEliminado, "El registro con placa $placa no debería existir después de la eliminación");
    }
}

//./vendor/bin/phpunit --bootstrap vendor/autoload.php test/TestVehiculos.php --colors

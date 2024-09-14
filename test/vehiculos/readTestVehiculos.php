<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/api/PDO/vehiculos/modelojson.php'; // Asegúrate de incluir el archivo correcto con la clase modelojson

class readTestVehiculos extends TestCase
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

    public function testReadVehiculoModelByNumDoc()
    {
        // El número de documento que queremos leer
        $placa = 'LOU258'; 

        $tabla = 'vehiculos';

        // Llama al método para leer el registro con el placa específico
        $result = $this->datos->readVehiculoModel($tabla, $placa); // Pasar $placa aquí

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
                $this->assertEquals('11', $vehiculo['id_conductor']);
                $this->assertEquals('Renult', $vehiculo['marca']);
                $this->assertEquals('2021', $vehiculo['modelo']);
                $this->assertEquals('Azul', $vehiculo['color']);
                $this->assertEquals('TV002', $vehiculo['tipo_vehiculo']);
                break;
            }
        }

        // Verifica que el registro haya sido encontrado
        $this->assertTrue($found);
    }
}

// ./vendor/bin/phpunit --bootstrap vendor/autoload.php test/vehiculos/readTestVehiculos.php --colors

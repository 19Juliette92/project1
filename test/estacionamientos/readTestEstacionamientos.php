<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/api/PDO/estacionamientos/modelojson.php'; // Asegúrate de incluir el archivo correcto con la clase modelojson

class readTestEstacionamientos extends TestCase
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

    public function testReadEstacionamientoModelByNumDoc()
    {
        // El número de documento que queremos leer
        $no_estacionamiento = '1101'; 

        $tabla = 'estacionamientos';

        // Llama al método para leer el registro con el no_estacionamiento específico
        $result = $this->datos->readEstacionamientoModel($tabla, $no_estacionamiento); // Pasar $no_estacionamiento aquí

        // Verifica que el método devuelva un array y que contenga el registro correcto
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);

        // Busca el registro con el no_estacionamiento especificado en los resultados
        $found = false;
        foreach ($result as $estacionamiento) {
            if ($estacionamiento['no_estacionamiento'] === $no_estacionamiento) {
                $found = true;

                // Depuración: Muestra los datos recuperados
                var_dump($estacionamiento); 

                // Verifica que los datos sean correctos
                $this->assertEquals($no_estacionamiento, $estacionamiento['no_estacionamiento']);
                $this->assertEquals('11', $estacionamiento['id_titular']);
                $this->assertEquals('LOU258', $estacionamiento['placa']);
                $this->assertEquals('6', $estacionamiento['id_inmueble']);
                $this->assertEquals('2', $estacionamiento['id_usuario']);
                break;
            }
        }

        // Verifica que el registro haya sido encontrado
        $this->assertTrue($found);
    }
}

// ./vendor/bin/phpunit --bootstrap vendor/autoload.php test/estacionamientos/readTestEstacionamiento.php --colors

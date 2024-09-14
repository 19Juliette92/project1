<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/api/PDO/inmuebles/modelojson.php'; // Asegúrate de incluir el archivo correcto con la clase modelojson

class readTestInmuebles extends TestCase
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

    public function testReadInmuebleModelByNumDoc()
    {
        // El número de documento que queremos leer
        $id_inmueble = '5'; 

        $tabla = 'inmuebles';

        // Llama al método para leer el registro con el id_inmueble específico
        $result = $this->datos->readInmuebleModel($tabla, $id_inmueble); // Pasar $id_inmueble aquí

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
                $this->assertEquals('10', $inmueble['bloque']);
                $this->assertEquals('404', $inmueble['apto']);
                $this->assertEquals('11', $inmueble['id_titular']);
                break;
            }
        }

        // Verifica que el registro haya sido encontrado
        $this->assertTrue($found);
    }
}

// ./vendor/bin/phpunit --bootstrap vendor/autoload.php test/inmuebles/readTestInmuebles.php --colors

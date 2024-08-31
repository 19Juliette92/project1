<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../src/api/PDO/personas/modelojson.php'; // Asegúrate de incluir el archivo correcto con la clase modelojson

class readTestPersonas extends TestCase
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

    public function testReadPersonaModelByNumDoc()
    {
        // El número de documento que queremos leer
        $num_doc = '1234567890'; 

        $tabla = 'personas';

        // Llama al método para leer el registro con el num_doc específico
        $result = $this->datos->readPersonaModel($tabla, $num_doc); // Pasar $num_doc aquí

        // Verifica que el método devuelva un array y que contenga el registro correcto
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);

        // Busca el registro con el num_doc especificado en los resultados
        $found = false;
        foreach ($result as $persona) {
            if ($persona['num_doc'] === $num_doc) {
                $found = true;

                // Depuración: Muestra los datos recuperados
                var_dump($persona); 

                // Verifica que los datos sean correctos
                $this->assertEquals('TP001', $persona['tipo_persona']);
                $this->assertEquals('CC', $persona['tip_doc']);
                $this->assertEquals($num_doc, $persona['num_doc']);
                $this->assertEquals('Carlos Andres', $persona['nombres']);
                $this->assertEquals('Gomez Mejia', $persona['apellidos']);
                $this->assertEquals('M', $persona['genero']);
                $this->assertEquals('carlos.andres@example.com', $persona['email']);
                $this->assertEquals('3109876543', $persona['telefono']);
                break;
            }
        }

        // Verifica que el registro haya sido encontrado
        $this->assertTrue($found);
    }
}

// ./vendor/bin/phpunit --bootstrap vendor/autoload.php test/personas/readTestPersonas.php --colors

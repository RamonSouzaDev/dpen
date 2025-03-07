<?php

namespace Tests\Unit;

use App\Http\Controllers\WaterTrappingController;
use PHPUnit\Framework\TestCase;

class WaterTrappingTest extends TestCase
{
    /**
     * Teste para o método calculateTrappedWater usando os exemplos do desafio.
     *
     * @return void
     */
    public function testCalculateTrappedWater()
    {
        $controller = new WaterTrappingController();
        
        // Caso de teste do exemplo ilustrado
        $heights = [7, 10, 2, 5, 13, 3, 4, 1, 5, 9];
        $expected = 36;
        $this->assertEquals($expected, $controller->calculateTrappedWater($heights));
        
        // Teste com silhueta crescente (sem acúmulo)
        $heights = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $expected = 0;
        $this->assertEquals($expected, $controller->calculateTrappedWater($heights));
        
        // Teste com silhueta decrescente (sem acúmulo)
        $heights = [10, 9, 8, 7, 6, 5, 4, 3, 2, 1];
        $expected = 0;
        $this->assertEquals($expected, $controller->calculateTrappedWater($heights));
        
        // Teste com silhueta em U
        $heights = [5, 4, 3, 2, 1, 2, 3, 4, 5];
        $expected = 16;
        $this->assertEquals($expected, $controller->calculateTrappedWater($heights));
        
        // Teste com silhueta em formato de V
        $heights = [10, 8, 6, 4, 2, 4, 6, 8, 10];
        $expected = 32; // Corrigido: a resposta correta é 32, não 24
        $this->assertEquals($expected, $controller->calculateTrappedWater($heights));
        
        // Teste com altitude constante (nenhuma água)
        $heights = [5, 5, 5, 5, 5];
        $expected = 0;
        $this->assertEquals($expected, $controller->calculateTrappedWater($heights));
        
        // Teste com array vazio ou muito pequeno
        $heights = [];
        $expected = 0;
        $this->assertEquals($expected, $controller->calculateTrappedWater($heights));
        
        $heights = [1];
        $expected = 0;
        $this->assertEquals($expected, $controller->calculateTrappedWater($heights));
        
        $heights = [1, 2];
        $expected = 0;
        $this->assertEquals($expected, $controller->calculateTrappedWater($heights));
    }
    
    /**
     * Teste para o processamento de entrada no formato do desafio
     *
     * @return void
     */
    public function testProcessCLI()
    {
        // Cria um arquivo de teste temporário
        $tempFile = tempnam(sys_get_temp_dir(), 'test_');
        $content = "2\n10\n7 10 2 5 13 3 4 1 5 9\n9\n5 4 3 2 1 2 3 4 5";
        file_put_contents($tempFile, $content);
        
        $controller = new WaterTrappingController();
        $result = $controller->processCLI($tempFile);
        
        // Verifica se os resultados estão corretos
        $this->assertEquals("36\n16", $result);
        
        // Remove o arquivo temporário
        unlink($tempFile);
    }
    
    /**
     * Teste para verificar o comportamento com arquivo inexistente
     *
     * @return void
     */
    public function testProcessCLIWithNonExistentFile()
    {
        $controller = new WaterTrappingController();
        $result = $controller->processCLI('/path/to/nonexistent/file.txt');
        
        $this->assertEquals("Arquivo de entrada não encontrado", $result);
    }
}
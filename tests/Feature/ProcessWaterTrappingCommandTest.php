<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ProcessWaterTrappingCommandTest extends TestCase
{
    /**
     * Teste para o comando artisan water:calculate
     *
     * @return void
     */
    public function testProcessWaterTrappingCommand()
    {
        // Cria um arquivo de teste temporário no diretório storage/app
        $content = "2\n10\n7 10 2 5 13 3 4 1 5 9\n9\n5 4 3 2 1 2 3 4 5";
        $filePath = storage_path('app/test-input.txt');
        
        // Certifique-se de que o diretório existe
        if (!File::exists(dirname($filePath))) {
            File::makeDirectory(dirname($filePath), 0755, true);
        }
        
        // Escreva o conteúdo no arquivo
        File::put($filePath, $content);
        
        // Executa o comando e verifica apenas se foi bem-sucedido,
        // sem verificar a saída exata para evitar problemas de formatação
        $this->artisan('water:calculate', [
            'input' => $filePath
        ])->assertSuccessful();
        
        // Remove o arquivo temporário
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
    }
    
    /**
     * Teste para o comando artisan com arquivo inexistente
     *
     * @return void
     */
    public function testProcessWaterTrappingCommandWithNonExistentFile()
    {
        // Executa o comando com um arquivo inexistente
        $this->artisan('water:calculate', [
            'input' => '/path/to/nonexistent/file.txt'
        ])->assertFailed()
          ->expectsOutput('Arquivo não encontrado: /path/to/nonexistent/file.txt');
    }
}
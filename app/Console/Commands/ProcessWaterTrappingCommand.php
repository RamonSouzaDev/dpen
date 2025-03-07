<?php

namespace App\Console\Commands;

use App\Http\Controllers\WaterTrappingController;
use Illuminate\Console\Command;

class ProcessWaterTrappingCommand extends Command
{
    /**
     * O nome e a assinatura do comando de console.
     *
     * @var string
     */
    protected $signature = 'water:calculate {input : Caminho para o arquivo de entrada}';

    /**
     * A descrição do comando de console.
     *
     * @var string
     */
    protected $description = 'Calcula o acúmulo de água baseado no formato especificado pelo desafio';

    /**
     * Executa o comando de console.
     *
     * @return int
     */
    public function handle()
    {
        $inputFile = $this->argument('input');
        
        if (!file_exists($inputFile)) {
            $this->error("Arquivo não encontrado: {$inputFile}");
            return 1;
        }
        
        $controller = new WaterTrappingController();
        $result = $controller->processCLI($inputFile);
        
        $this->info($result);
        
        return 0;
    }
}
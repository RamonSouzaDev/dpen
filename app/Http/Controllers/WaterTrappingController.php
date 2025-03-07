<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class WaterTrappingController extends Controller
{
    /**
     * Exibe a página inicial
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('water-trapping.index');
    }

    /**
     * Processa o arquivo de entrada e retorna os resultados em JSON (API)
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function processFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input_file' => 'required|file|mimes:txt',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $file = $request->file('input_file');
        $content = file_get_contents($file->getRealPath());
        
        $lines = explode("\n", $content);
        $numCases = (int) $lines[0];
        
        $results = [];
        $lineIndex = 1;
        
        for ($i = 0; $i < $numCases; $i++) {
            // Pula a linha com o tamanho do array (não precisamos dele na implementação)
            $lineIndex++;
            
            // Obtém a linha com o array
            $heightsStr = $lines[$lineIndex];
            $heights = array_map('intval', explode(' ', $heightsStr));
            
            // Calcula o acúmulo de água
            $trappedWater = $this->calculateTrappedWater($heights);
            $results[] = $trappedWater;
            
            $lineIndex++;
        }
        
        return response()->json(['results' => $results]);
    }
    
    /**
     * Processa o arquivo de entrada e retorna a página web com resultados
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function processFileWeb(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input_file' => 'required|file|mimes:txt',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('input_file');
        $content = file_get_contents($file->getRealPath());
        
        $lines = explode("\n", $content);
        $numCases = (int) $lines[0];
        
        $results = [];
        $allHeights = [];
        $lineIndex = 1;
        
        for ($i = 0; $i < $numCases; $i++) {
            // Pula a linha com o tamanho do array
            $lineIndex++;
            
            // Obtém a linha com o array
            $heightsStr = $lines[$lineIndex];
            $heights = array_map('intval', explode(' ', trim($heightsStr)));
            
            // Calcula o acúmulo de água
            $trappedWater = $this->calculateTrappedWater($heights);
            $results[] = $trappedWater;
            $allHeights[] = $heights;
            
            $lineIndex++;
        }
        
        // Criar dados para visualização do primeiro caso
        $visualization = $this->prepareVisualizationData($allHeights[0]);
        
        return view('water-trapping.index', [
            'results' => $results,
            'visualization' => $visualization
        ]);
    }
    
    /**
     * Processo o input manualmente inserido no formato especificado (API)
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function processInput(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        
        $content = $request->input('input');
        $lines = explode("\n", $content);
        $numCases = (int) $lines[0];
        
        $results = [];
        $lineIndex = 1;
        
        for ($i = 0; $i < $numCases; $i++) {
            // Pula a linha com o tamanho do array
            $lineIndex++;
            
            // Obtém a linha com o array
            $heightsStr = $lines[$lineIndex];
            $heights = array_map('intval', explode(' ', $heightsStr));
            
            // Calcula o acúmulo de água
            $trappedWater = $this->calculateTrappedWater($heights);
            $results[] = $trappedWater;
            
            $lineIndex++;
        }
        
        return response()->json(['results' => $results]);
    }
    
    /**
     * Processa o input manualmente inserido e retorna a página web com resultados
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function processInputWeb(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $content = $request->input('input');
        $lines = explode("\n", $content);
        $numCases = (int) $lines[0];
        
        $results = [];
        $allHeights = [];
        $lineIndex = 1;
        
        for ($i = 0; $i < $numCases; $i++) {
            // Pula a linha com o tamanho do array
            $lineIndex++;
            
            // Obtém a linha com o array
            $heightsStr = $lines[$lineIndex];
            $heights = array_map('intval', explode(' ', trim($heightsStr)));
            
            // Calcula o acúmulo de água
            $trappedWater = $this->calculateTrappedWater($heights);
            $results[] = $trappedWater;
            $allHeights[] = $heights;
            
            $lineIndex++;
        }
        
        // Criar dados para visualização do primeiro caso
        $visualization = $this->prepareVisualizationData($allHeights[0]);
        
        return view('water-trapping.index', [
            'results' => $results,
            'visualization' => $visualization
        ]);
    }
    
    /**
     * Executa o cálculo em modo CLI e gera output diretamente
     *
     * @param string $inputFile
     * @return string
     */
    public function processCLI($inputFile)
    {
        if (!file_exists($inputFile)) {
            return "Arquivo de entrada não encontrado";
        }
        
        $content = file_get_contents($inputFile);
        $lines = explode("\n", $content);
        $numCases = (int) $lines[0];
        
        $results = [];
        $lineIndex = 1;
        
        for ($i = 0; $i < $numCases; $i++) {
            // Pula a linha com o tamanho do array
            $lineIndex++;
            
            // Obtém a linha com o array
            $heightsStr = $lines[$lineIndex];
            $heights = array_map('intval', explode(' ', trim($heightsStr)));
            
            // Calcula o acúmulo de água
            $trappedWater = $this->calculateTrappedWater($heights);
            $results[] = $trappedWater;
            
            $lineIndex++;
        }
        
        return implode("\n", $results);
    }
    
    /**
     * Prepara os dados para visualização gráfica do acúmulo de água
     *
     * @param array $heights
     * @return array
     */
    private function prepareVisualizationData(array $heights): array
    {
        $size = count($heights);
        $visualization = [];
        
        // Calcular a água para visualização
        // Pré-computar os máximos da esquerda e direita para cada posição
        $leftMax = array_fill(0, $size, 0);
        $rightMax = array_fill(0, $size, 0);
        
        // Preencher os valores máximos da esquerda
        $leftMax[0] = $heights[0];
        for ($i = 1; $i < $size; $i++) {
            $leftMax[$i] = max($heights[$i], $leftMax[$i - 1]);
        }
        
        // Preencher os valores máximos da direita
        $rightMax[$size - 1] = $heights[$size - 1];
        for ($i = $size - 2; $i >= 0; $i--) {
            $rightMax[$i] = max($heights[$i], $rightMax[$i + 1]);
        }
        
        // Fator de escala para melhor visualização
        $maxHeight = max($heights);
        $scaleFactor = 180 / max(1, $maxHeight);
        
        // Calcular a água acumulada em cada posição
        for ($i = 0; $i < $size; $i++) {
            $barHeight = $heights[$i];
            $waterLevel = min($leftMax[$i], $rightMax[$i]);
            $waterHeight = max(0, $waterLevel - $barHeight);
            
            $visualization[] = [
                'bar' => round($barHeight * $scaleFactor),
                'water' => round($waterHeight * $scaleFactor)
            ];
        }
        
        return $visualization;
    }
    
    /**
     * Calcula o acúmulo de água em um array de alturas
     *
     * @param array $heights
     * @return int
     */
    public function calculateTrappedWater(array $heights): int
    {
        if (count($heights) <= 2) {
            return 0; // Impossível acumular água com menos de 3 elementos
        }
        
        $totalWater = 0;
        $size = count($heights);
        
        // Pré-computar os máximos da esquerda e direita para cada posição
        $leftMax = array_fill(0, $size, 0);
        $rightMax = array_fill(0, $size, 0);
        
        // Preencher os valores máximos da esquerda
        $leftMax[0] = $heights[0];
        for ($i = 1; $i < $size; $i++) {
            $leftMax[$i] = max($heights[$i], $leftMax[$i - 1]);
        }
        
        // Preencher os valores máximos da direita
        $rightMax[$size - 1] = $heights[$size - 1];
        for ($i = $size - 2; $i >= 0; $i--) {
            $rightMax[$i] = max($heights[$i], $rightMax[$i + 1]);
        }
        
        // Calcular a água acumulada em cada posição
        for ($i = 0; $i < $size; $i++) {
            $waterLevel = min($leftMax[$i], $rightMax[$i]);
            $trappedWater = $waterLevel - $heights[$i];
            
            if ($trappedWater > 0) {
                $totalWater += $trappedWater;
            }
        }
        
        return $totalWater;
    }
}
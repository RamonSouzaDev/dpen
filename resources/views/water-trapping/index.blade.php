<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Acúmulo de Água</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .silhouette-grid {
            display: flex;
            align-items: flex-end;
            height: 200px;
            margin-bottom: 20px;
        }
        .bar {
            width: 30px;
            margin-right: 3px;
            background-color: #6c757d;
            position: relative;
        }
        .water {
            background-color: #0d6efd;
            position: absolute;
            bottom: 100%;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h1 class="mb-4">Calculadora de Acúmulo de Água</h1>
        
        <div class="row mb-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Upload de Arquivo</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('water.process-file') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="input_file" class="form-label">Arquivo de Entrada</label>
                                <input type="file" class="form-control" id="input_file" name="input_file" required>
                                <div class="form-text">Formato esperado conforme especificação do desafio.</div>
                            </div>
                            <button type="submit" class="btn btn-primary">Processar</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Entrada Manual</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('water.process-input') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="input" class="form-label">Texto de Entrada</label>
                                <textarea class="form-control" id="input" name="input" rows="8" required></textarea>
                                <div class="form-text">Cole o conteúdo no formato especificado.</div>
                            </div>
                            <button type="submit" class="btn btn-primary">Processar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        @if(isset($results))
        <div class="card mb-4">
            <div class="card-header">
                <h5>Resultados</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Caso</th>
                                <th>Acúmulo de Água</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $index => $result)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $result }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        
        @if(isset($visualization))
        <div class="card">
            <div class="card-header">
                <h5>Visualização</h5>
            </div>
            <div class="card-body">
                <div class="silhouette-grid">
                    @foreach($visualization as $height)
                    <div class="bar" style="height: {{ $height['bar'] }}px;">
                        @if(isset($height['water']) && $height['water'] > 0)
                        <div class="water" style="height: {{ $height['water'] }}px;"></div>
                        @endif
                    </div>
                    @endforeach
                </div>
                <p class="card-text">Total de água: {{ array_sum(array_column($visualization, 'water')) }} unidades</p>
            </div>
        </div>
        @endif
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
# Calculadora de Acúmulo de Água

![image](https://github.com/user-attachments/assets/f57bdbca-eb53-463a-90b8-d0aaf9663513)


![image](https://github.com/user-attachments/assets/956ce8ba-63d1-4690-88e0-645cb47443fc)


Este projeto implementa uma solução para o cálculo de acúmulo de água entre silhuetas, desenvolvido em Laravel, com Docker para um ambiente de desenvolvimento consistente.

## Sobre o Problema

O algoritmo calcula quanto de água fica acumulada entre as silhuetas de diferentes alturas. Por exemplo, dado o array `[7, 10, 2, 5, 13, 3, 4, 1, 5, 9]`, o acúmulo de água seria `36` unidades.

## Requisitos

- Docker e Docker Compose
- Git

## Estrutura do Projeto

- Aplicação Laravel com PHP 8.2
- Ambiente Docker com Nginx, PHP-FPM e MySQL
- Interface Web para upload de arquivos e entrada manual
- CLI para processamento via linha de comando
- Testes Unitários abrangentes

## Instalação e Execução

### 1. Clone o repositório

```bash
git clone https://github.com/seuusuario/rain-trap-calculator.git
cd rain-trap-calculator
```

### 2. Configure o ambiente

```bash
cp .env.example .env
```

### 3. Inicie o ambiente Docker

```bash
docker-compose up -d
```

###

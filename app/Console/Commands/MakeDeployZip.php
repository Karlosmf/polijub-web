<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ZipArchive;
use Symfony\Component\Process\Process;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Illuminate\Support\Str;

class MakeDeployZip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:deploy-zip {--name=deploy.zip}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera un paquete ZIP para despliegue en hosting compartido';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Iniciando proceso de empaquetado...');

        // 1. Ejecutar npm run build
        $this->info('📦 Ejecutando npm run build...');
        $process = new Process(['npm', 'run', 'build']);
        $process->setTimeout(300);
        $process->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });

        if (!$process->isSuccessful()) {
            $this->error('❌ Error al ejecutar npm run build.');
            return 1;
        }

        // 2. Crear el archivo ZIP
        $zipName = $this->option('name');
        $zipPath = base_path($zipName);

        // Si ya existe, eliminarlo para crear uno nuevo
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) !== TRUE) {
            $this->error('❌ No se pudo crear el archivo ZIP.');
            return 1;
        }

        $this->info("📂 Agregando archivos al paquete: {$zipName}");

        $rootPath = base_path();
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        $count = 0;
        foreach ($files as $name => $file) {
            if ($file->isDir()) {
                continue;
            }

            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($rootPath) + 1);

            // --- REGLAS DE EXCLUSIÓN ---
            
            // Excluir vendor
            if (Str::startsWith($relativePath, 'vendor' . DIRECTORY_SEPARATOR)) {
                continue;
            }

            // Excluir archivos dentro de bootstrap/cache (mantener gitignore si existiera, o solo limpiar archivos generados)
            if (Str::startsWith($relativePath, 'bootstrap' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR)) {
                continue;
            }

            // Excluir archivos ocultos (dot files)
            // Se comprueba si el nombre del archivo empieza con un punto, o si alguna parte del path empieza con punto (.git, .env, etc)
            $pathParts = explode(DIRECTORY_SEPARATOR, $relativePath);
            $hasDotFile = collect($pathParts)->contains(fn($part) => Str::startsWith($part, '.'));
            
            if ($hasDotFile) {
                continue;
            }

            // Excluir el propio archivo zip que estamos creando
            if ($relativePath === $zipName) {
                continue;
            }

            $zip->addFile($filePath, $relativePath);
            $count++;
        }

        $zip->close();

        $this->info("✅ Proceso finalizado con éxito.");
        $this->info("📦 Se han empaquetado {$count} archivos en '{$zipName}'.");
        $this->line("⚠️ Recuerda que al subirlo al servidor deberás ejecutar 'composer install' si tienes acceso SSH, o subir la carpeta vendor por separado si no lo tienes.");
        
        return 0;
    }
}

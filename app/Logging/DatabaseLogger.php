<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use App\Models\Log; // Reemplaza 'Log' con el nombre del modelo si has creado uno
use Monolog\LogRecord;

class DatabaseLogger extends AbstractProcessingHandler
{
    protected function write(LogRecord $record): void
    {
        $log = new Log();
        $log->Nivel = $record['level'];
        $log->Mensaje = $record['message'];
        $log->Contexto = json_encode($record['context']);
        // Agrega otros campos según tu estructura de tabla
        $log->save();
    }

    public function __invoke(array $config)
    {
        return new Logger(
            $config['name'] ?? 'database',
            [$this]
        );
    }

}
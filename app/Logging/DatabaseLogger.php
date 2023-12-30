<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Level;
use Monolog\Handler\AbstractProcessingHandler;
use App\Models\Log;
use Monolog\LogRecord;

class DatabaseLogger extends AbstractProcessingHandler
{
    protected function write(LogRecord $record): void
    {
        $context['user_id'] = auth()->user()->id ?? null;
        $context['route'] = request()->route()->uri;
        $log = new Log();
        $log->Nivel = Level::fromValue($record['level'])->getName();
        $log->Mensaje = $record['message'];
        $log->Contexto = json_encode($record['context']);
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
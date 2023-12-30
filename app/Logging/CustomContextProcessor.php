<?php

namespace App\Logging;

use Monolog\Processor\ProcessorInterface;
use Monolog\LogRecord;

class CustomContextProcessor implements ProcessorInterface
{
    public function process(LogRecord $record): LogRecord
    {
        $context = $record['context'];
        $context['UsuarioId'] = auth()->user()->id ?? null;
        $context['IP'] = request()->ip();
        $context['Ruta'] = [
            'URL' => request()->fullUrl(),
            'URI' => request()->route()->uri,
            'UserAgent' => request()->userAgent(),
            'Metodo' => request()->route()->methods(),
        ];

        return $record->with(context: $context);
    }

    public function __invoke(LogRecord $record): LogRecord
    {
        return $this->process($record);
    }
}

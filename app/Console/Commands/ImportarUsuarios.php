<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usuario;
use App\Models\Persona;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;


class ImportarUsuarios extends Command
{
    protected $signature = 'import:users {file}';

    protected $description = 'Import users from a CSV file';

    public function handle()
    {
        $file = $this->argument('file');
        $csv = Reader::createFromPath($file, 'r');
        $csv->setHeaderOffset(0); // Esto indica que la primera fila es la fila de encabezado
        $csv->setDelimiter(';');

        foreach ($csv as $row) {
            $row['Username'] = strtolower($row['Username']);
            $row['Nombre'] = strtolower($row['Nombre']);
            $row['Apellido'] = strtolower($row['Apellido']);
            $row['Rut'] = strtolower($row['Rut']);
            $row['Email'] = strtolower($row['Email']);
            $row['Password'] = bcrypt($row['Password']);

                $usuario = new Usuario();
                $usuario->validate($row);
                $usuario->fill($row);
                
                $persona = new Persona();
                $persona->validate($row);
    
                DB::beginTransaction();
                $usuario->save();
                $row['UsuarioId']= $usuario->Id;
                $persona->fill($row);
                $persona->save();          
    
                DB::commit(); 

        $this->info('Users imported successfully!');
        }
    }
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Arr;

class MakeDBModel extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     * eg:  php artisan make:inModel delivery_limit
     */
    protected $signature = 'make:DBModel {table} {--path=} {--module=} {--modelName=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description ='生成数据库Model 与 Repo';


    protected $db;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!app()->environment('local', 'develop')) {
            $this->error('Develop env only!');
            return false;
        }

        $table  = $this->argument('table');
        $path = $this->option('path');
        $this->db = \Config::get('database.connections.mysql.database');
        $modelName = $this->option('modelName');
        $module = $this->option('module');
        if (!$modelName) {
            $modelName = ucfirst(camel_case(str_replace('dove_', '', $table)));
        }
        $namespace = "App\\Modules\\Models".($path ? '\\'.ucfirst($path) : '');
        $dirPath   = sprintf("./app/Modules/Models/%s%s", $path ? ucfirst($path).'/' : '', $modelName.'.php');
        $repoName = $modelName;
        $repoDir = sprintf("./app/Modules/Repos/%s%s", $path ? ucfirst($path).'/' : '', $repoName.'Repository.php');
        

        // if ($this->files->exists($dirPath)) {
        //      $this->error("model {$modelName} 已经存在");
        //      return false;
        // }

        // if ($this->files->exists($repoDir)) {
        //     $this->error("repo {$modelName} 已经存在");
        //     return false;
        // }

        $this->makeDirectory($dirPath);
        $this->makeDirectory($repoDir);

        list($columns, $primaryKey, $filterDelete) = $this->formatColumns($this->getColumns($table));
        if (empty($columns)) {
            $this->error("Table {$table} not exists");
            return false;
        }

        $property = $this->getPropertyContent($columns);

        $data = [
            'author'       => get_current_user(),
            'date'         => date('Y-m-d H:i:s'),
            'namespace'    => $namespace,
            'modelName'    => $modelName,
            'property'     => $property,
            'primaryKey'   => $primaryKey,
            'schema'       => $this->db,
            'tableName'    => $table,
            'filterDelete' => $filterDelete,
            'phptag'       => '<?php ',
            'table'        => 'protected $table = "'.$table.'";'
        ];

        $strings = view('dbmodel', $data)->render();
        file_put_contents($dirPath, $strings);
        $this->info("Make model: {$modelName} success!");

        $data['namespace'] = "App\\Modules\\Repos".($path ? '\\'.ucfirst($path) : '');
        $strings = view('db-repo', $data)->render();
        file_put_contents($repoDir, $strings);
        $this->info("Make Repo: {$modelName} success!");
        return true;
    }

    private function getPropertyContent($columns) {
        return ' '.PHP_EOL.join(PHP_EOL, array_map(function($column) {
            return " * @property {$column['type']} {$column['name']} {$column['comment']}";
        }, $columns));
    }

    private function formatColumns($columnsList) {
        $resultList = [];
        $primaryKey = '';
        $filterDelete = false;

        foreach ($columnsList as $row) {
            $resultList[] = [
                'name' => $row['COLUMN_NAME'],
                'type' => $this->isStringColumns($row['DATA_TYPE']) ? 'string' : 'int',
                'comment' => Arr::get($row, 'COLUMN_COMMENT', '')
            ];
            if (empty($primaryKey)) $primaryKey = strtolower($row['COLUMN_KEY']) == 'pri' ? $row['COLUMN_NAME'] : '';
            if (!$filterDelete) $filterDelete = $row['COLUMN_NAME'] == 'is_delete';
        }

        return [
            $resultList,
            $primaryKey,
            $filterDelete ? PHP_EOL.'        \'filterDelete\' => true,' : ''
        ];
    }

    private function isStringColumns($type) {
        return stripos($type, 'int') === false && !in_array($type, ['float', 'DOUBLE']);
    }

    private function getColumns($table)
    {
        $table = 'css_' . $table;
        $sql = sprintf('select * from information_schema.columns where table_schema = "%s" and table_name = "%s"',  $this->db, $table);
        $result = \DB::select(\DB::raw($sql));
        return array_map(function ($value) {
            return (array)$value;
        }, $result);
    }


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return './resources/assets/template/inModel.stub';
    }

}


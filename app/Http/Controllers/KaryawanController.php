<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GroceryCrud\Core\GroceryCrud;
use Illuminate\Support\Facades\Auth;

class KaryawanController extends Controller
{
    private function _getDatabaseConnection() {
        $databaseConnection = config('database.default');
        $databaseConfig = config('database.connections.' . $databaseConnection);


        return [
            'adapter' => [
                'driver' => 'Pdo_Mysql',
                'database' => $databaseConfig['database'],
                'username' => $databaseConfig['username'],
                'password' => $databaseConfig['password'],
                'charset' => 'utf8'
            ]
        ];
    }

    private function _getGroceryCrudEnterprise() {
        $database = $this->_getDatabaseConnection();
        $config = config('grocerycrud');

        $crud = new GroceryCrud($config, $database);
        $crud->unsetSettings();

        return $crud;
    }

    private function _show_output($output, $title = '') {
        if ($output->isJSONResponse) {
            return response($output->output, 200)
                  ->header('Content-Type', 'application/json')
                  ->header('charset', 'utf-8');
        }

        $css_files = $output->css_files;
        $js_files = $output->js_files;
        $output = $output->output;

        return view('grocery', [
            'output' => $output,
            'css_files' => $css_files,
            'js_files' => $js_files,
            'title' => $title
        ]);
    }

    public function konsumen()
    {
        $title = "Daftar Konsumen";

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setTable('consuments');
        $crud->setSkin('bootstrap-v4');
        $crud->setSubject('Konsumen', 'Daftar Konsumen');
        $crud->unsetColumns(['created_at', 'updated_at', 'user_id']);
        $crud->unsetFields(['created_at', 'updated_at', 'user_id']);
        $crud->callbackBeforeInsert(function ($s) {
            $s->data['user_id'] = Auth::id();
            $s->data['created_at'] = now();
            $s->data['updated_at'] = now();
            return $s;
        });
        $crud->callbackBeforeUpdate(function ($s) {
            $s->data['updated_at'] = now();
            return $s;
        });
        $output = $crud->render();

        return $this->_show_output($output, $title);
    }
}

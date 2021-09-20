<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GroceryCrud\Core\GroceryCrud;

class AdminController extends Controller
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

    public function posisi()
    {
        $title = "Daftar Posisi";

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setTable('positions');
        $crud->setSkin('bootstrap-v4');
        $crud->setSubject('Posisi', 'Daftar Posisi');
        $crud->columns(['name']);
        $crud->fields(['name']);
        $crud->displayAs([
            'name' => 'Posisi',
        ]);
        $crud->callbackBeforeInsert(function ($s) {
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

    public function pengumuman()
    {
        $title = "Daftar Pengumuman";

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setTable('announcements');
        $crud->setSkin('bootstrap-v4');
        $crud->setSubject('Pengumuman', 'Daftar Pengumuman');
        $crud->columns(['deskripsi', 'poster']);
        $crud->fields(['deskripsi', 'poster']);
        $crud->requiredFields(['deskripsi','poster']);
        $crud->setFieldUpload('poster','storage','../storage');
        $crud->setTexteditor(['deskripsi']);
        $crud->callbackColumn('poster', function ($value, $row) {
            $img = '<a href="'.asset('storage/'.$value).'" target="_blank"><img src="'.asset('storage/'.$value).'" height="75"></a>';
            return $img;
        });
        $crud->callbackBeforeInsert(function ($s) {
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

    public function tasks()
    {
        $title = "DB Client";

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setTable('consuments');
        $crud->setSkin('bootstrap-v4');
        $crud->setSubject('Client', 'DB Client');
        $crud->unsetColumns(['created_at', 'updated_at']);
        $crud->unsetFields(['created_at', 'updated_at']);
        $crud->setRelation('user_id','users','name');
        $crud->displayAs('user_id','Sales');
        $crud->callbackBeforeInsert(function ($s) {
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

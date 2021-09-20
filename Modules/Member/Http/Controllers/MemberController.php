<?php

namespace Modules\Member\Http\Controllers;

use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use GroceryCrud\Core\GroceryCrud;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
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

    public function index()
    {
        $title = "Daftar Sales";

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setTable('users');
        $crud->setSkin('bootstrap-v4');
        $crud->setSubject('Sales', 'Daftar Sales');
        $crud->unsetAdd();
        $crud->columns(['nip','name', 'role_id', 'position', 'jenis_kelamin', 'email', 'updated_at']);
        $crud->addFields(['nip','name', 'role_id', 'position', 'jenis_kelamin', 'email', 'password']);
        $crud->editFields(['nip','name', 'role_id', 'position', 'jenis_kelamin', 'email']);
        $crud->setRelation('role_id', 'roles', 'name');
        $crud->displayAs([
            'role_id' => 'Status',
            'nip' => 'NIP',
            'name' => 'Nama Lengkap',
            'position' => 'Jabatan',
            'jenis_kelamin' => 'Jenis Kelamin'
        ]);
        $crud->callbackAfterInsert(function ($s) {
            $user = User::find($s->insertId);
            $user->password = Hash::make($user->password);
            $user->save();
            return $s;
        });
        $crud->callbackAfterUpdate(function ($s) {
            $user = User::find($s->primaryKeyValue);
            $user->touch();
            return $s;
        });
        $output = $crud->render();

        return $this->_show_output($output, $title);
    }
}

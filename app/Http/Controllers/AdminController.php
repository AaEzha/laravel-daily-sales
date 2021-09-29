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

    public function sales()
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

    public function client()
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

        $crud->setRelation('name_sales','sales','name');
        $crud->setRelation('name_spv','spvs','name');
        $crud->setRelation('minggu_ke','weeks','name');
        $crud->setRelation('bulan','months','name');
        $crud->setRelation('status_database','status_databases','name');
        $crud->setRelation('program_sumber_informasi','information_sources','name');
        $crud->setRelation('asal_database','database_sources','name');
        $crud->setRelation('project','projects','name');
        $crud->setRelation('status_konsumen','consument_statuses','name');
        $crud->setRelation('keterangan','notes','name');
        $output = $crud->render();

        return $this->_show_output($output, $title);
    }

    public function tasks()
    {
        $title = "DB Task Client";

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setTable('consuments');
        $crud->setSkin('bootstrap-v4');
        $crud->setSubject('Client', 'DB Client');
        $crud->unsetColumns(['created_at', 'updated_at']);
        $crud->unsetFields(['created_at', 'updated_at']);
        $crud->fields(['name','status_konsumen','handphone','user_id']);
        $crud->columns(['name','status_konsumen','handphone','user_id']);
        $crud->setRelation('user_id','users','name');
        $crud->displayAs('user_id','Sales');
        $crud->displayAs('status_konsumen','Task Client');
        $crud->displayAs('name','Nama Client');
        $crud->callbackBeforeInsert(function ($s) {
            $s->data['created_at'] = now();
            $s->data['updated_at'] = now();
            return $s;
        });
        $crud->callbackBeforeUpdate(function ($s) {
            $s->data['updated_at'] = now();
            return $s;
        });
        $crud->setRelation('status_konsumen','consument_statuses','name');
        $output = $crud->render();

        return $this->_show_output($output, $title);
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSpvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spvs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $arr = ['Pa Wawan','Pa Ono','Counter'];
        foreach($arr as $name):
            DB::table('spvs')->insert(['name' => $name]);
        endforeach;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spvs');
    }
}

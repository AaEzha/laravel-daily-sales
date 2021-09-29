<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $arr = ['Akad','Hot Prospek (janji site visit/booking)','Budget DP','Budget Cicilan','Budget Biaya KPR','Fasilitas','Infrastruktur / Kawasan','Lokasi','B.I Check / Collect','Tanya tanya informasi','Diskusi'];
        foreach($arr as $name):
            DB::table('notes')->insert(['name' => $name]);
        endforeach;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
}

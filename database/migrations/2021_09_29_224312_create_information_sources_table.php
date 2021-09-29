<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateInformationSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $arr = ['Ads (instagram)','Website (web form)','Leads Generation (LG form)','Rumah123','Olx','Rumahcom','Google','Referral','Flyering','Spanduk','OT/Pameran','Piket Lokasi'];
        foreach($arr as $name):
            DB::table('information_sources')->insert(['name' => $name]);
        endforeach;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('information_sources');
    }
}

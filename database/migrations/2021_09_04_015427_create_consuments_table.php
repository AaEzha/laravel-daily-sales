<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consuments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('handphone');
            $table->string('name_sales');
            $table->string('name_spv');
            $table->string('minggu_ke');
            $table->string('bulan');
            $table->string('status_database');
            $table->string('program_sumber_informasi');
            $table->string('asal_database');
            $table->string('project');
            $table->string('status_konsumen');
            $table->string('keterangan');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consuments');
    }
}

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
            $table->string('name')->nullable();
            $table->string('handphone')->nullable();
            $table->string('name_sales')->nullable();
            $table->string('name_spv')->nullable();
            $table->string('minggu_ke')->nullable();
            $table->string('bulan')->nullable();
            $table->string('status_database')->nullable();
            $table->string('program_sumber_informasi')->nullable();
            $table->string('asal_database')->nullable();
            $table->string('project')->nullable();
            $table->string('status_konsumen')->nullable();
            $table->string('keterangan')->nullable();
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

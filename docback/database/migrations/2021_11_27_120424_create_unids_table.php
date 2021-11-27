<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unids', function (Blueprint $table) {
            $table->id();
            $table->string("empresa");
            $table->string("unidad");
            $table->string("sigla");
            $table->string("codigo");
            $table->string("descripcion");
            $table->string("detalle");
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
        Schema::dropIfExists('unids');
    }
}

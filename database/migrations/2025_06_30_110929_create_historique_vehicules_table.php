<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriqueVehiculesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historique_vehicules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicule_id');
            $table->string('type');
            $table->string('plaque');
            $table->timestamp('date_entree')->nullable();
            $table->timestamp('date_sortie')->nullable();
            $table->string('action');
            $table->timestamp('date_action')->nullable();
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
        Schema::dropIfExists('historique_vehicules');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriquePaiementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historique_paiements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paiement_id');
            $table->unsignedBigInteger('vehicule_id');
            $table->decimal('montant', 10, 2);
            $table->timestamp('date_paiement')->nullable();
            $table->string('statut');
            $table->string('action'); // ajout, modification, suppression
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
        Schema::dropIfExists('historique_paiements');
    }
}

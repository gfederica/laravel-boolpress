<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_tag', function (Blueprint $table) {
            // possiamo commentare l'id e in quel caso importeremmo solo l'id dei dati relazionati
            $table->id();
            //se cancelliamo l'id indichiamo le primary key:
            // $table->primary(['post_id', 'tag_id']);

            // facciamo lo stesso iter che per la migration uno a uno / uno a molti, ma importiamo due foreign_key (una per ogni model relazionato)
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                //cascade cancella "a cascata" la riga di relazione, se viene cancellata una delle due fk non c'è alcuna associazione da verificare, quindi tutto il record viene eliminato
                ->onDelete('CASCADE');

            $table->unsignedBigInteger('tag_id');
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onDelete('CASCADE');  
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_tag');
    }
}

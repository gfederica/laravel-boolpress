<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//update della tabella posts, dobbiamo aggiungere la foreign key per la relazione fra posts e categories
//creo l'update e faccio il migrate

class UpdatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')
            //voglio che sia possibile creare post senza categoria, perciò devo prevedere la possibilità di campi "null" senza generare errori
                ->nullable()
            //posizione della foreign key nella tabella
                ->after('id');

            // dichiaro che category_id è una foreign key (tra posts e categories)
            $table->foreign('category_id')
            // deve fare riferimento all'id della tabella categories. onDelete gestisce la cancellazione della categoria, con set null il post non viene cancellato ma perde la categoria
                ->references('id')
                ->on('categories')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            // prevedo una cancellazione, cancellando sia la colonna sia il vincolo associato. devo PRIMA eliminare i vincoli per eliminare la colonna. Si scrive con questa sintassi
            $table->dropForeign('posts_category_id_foreign');

            $table->dropColumn('category_id');
        });
    }
}

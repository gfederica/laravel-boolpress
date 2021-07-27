<?php

use Illuminate\Database\Seeder;
use App\Category;
use Illuminate\Support\Str;


class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // creo un nuovo oggetto istanza della classe Model (Category), valorizzo le proprietà e lo trasformo in una riga del database col metodo save.

        $categories = [
            "Attualità",
            "Politica",
            "Lifestyle",
            "Tecnologia",
            "Redazione"
        ];

        
        // soluzione con ciclo for ($i = 0; $i < count($categories); $i++) {
        foreach($categories as $category) {   
            // 1 - creazione nuovo oggetto
            $newCategory = new Category();

            // 2 - valorizzazione proprietà
            // $newCategory->name = $categories[$i];
            $newCategory->name = $category;
            $newCategory->slug = Str::slug($newCategory->name, '-');

            // 3 - salvataggio
            $newCategory->save();
        }
    }
}

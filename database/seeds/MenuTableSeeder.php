<?php

use Illuminate\Database\Seeder;
use App\Menu;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::insert([
            [
                'uuid'=> Str::uuid(),
                'name' => 'Margherita',
                'image' => 'https://cdn.pixabay.com/photo/2016/04/09/09/22/pizza-1317699__480.jpg',
                'amount' => 5,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
               
            ],
            [
                'uuid'=> Str::uuid(),
                'name' => 'Marinara',
                'image' => 'https://cdn.pixabay.com/photo/2014/07/08/12/34/pizza-386717__480.jpg',
                'amount' => 3,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
               
            ],
            [
                'uuid'=> Str::uuid(),
                'name' => 'Quattro Stagioni',
                'image' => 'https://cdn.pixabay.com/photo/2017/01/03/11/33/pizza-1949183__480.jpg',
                'amount' => 8,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
               
            ],
            [
                'uuid'=> Str::uuid(),
                'name' => 'Carbonara',
                'image' => 'https://cdn.pixabay.com/photo/2017/06/07/10/53/pizza-2380025__480.jpg',
                'amount' => 4,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
               
            ],
            [
                'uuid'=> Str::uuid(),
                'name' => 'Frutti di Mare',
                'image' => 'https://cdn.pixabay.com/photo/2018/04/11/03/13/food-3309418__480.jpg',
                'amount' => 2,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
               
            ],
            [
                'uuid'=> Str::uuid(),
                'name' => 'Quattro Formaggi',
                'image' => 'https://cdn.pixabay.com/photo/2017/02/15/10/57/pizza-2068271__480.jpg',
                'amount' => 6,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
               
            ],
            [
                'uuid'=> Str::uuid(),
                'name' => 'Crudo',
                'image' => 'https://cdn.pixabay.com/photo/2016/06/08/00/03/pizza-1442945__480.jpg',
                'amount' => 7,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
               
            ],
            [
                'uuid'=> Str::uuid(),
                'name' => 'Napoletana',
                'image' => 'https://cdn.pixabay.com/photo/2016/02/16/07/39/pizza-1202775__480.jpg',
                'amount' => 10,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
               
            ],
            [
                'uuid'=> Str::uuid(),
                'name' => 'Pugliese',
                'image' => 'https://cdn.pixabay.com/photo/2017/11/23/16/57/pizza-2973200__480.jpg',
                'amount' => 8,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ],

            [
                'uuid'=> Str::uuid(),
                'name' => 'Montanara',
                'image' => 'https://cdn.pixabay.com/photo/2019/08/04/20/09/pizza-4384650__480.jpg',
                'amount' => 11,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
               
            ],
            
        ]);
    }
}

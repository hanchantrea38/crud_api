<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Movie::create([
            'name' => 'The Shawshank Redemption',
            'date' => '1994-10-14',
            'desc' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
        ]);

        Movie::create([
            'name' => 'The Dark Knight',
            'date' => '2008-07-18',
            'desc' => 'When the menace known as the Joker emerges from his mysterious past, he wreaks havoc and chaos on the people of Gotham.',
        ]);

        Movie::create([
            'name' => 'Inception',
            'date' => '2010-07-16',
            'desc' => 'A skilled thief who steals corporate secrets through dream-sharing technology is given the inverse task of planting an idea.',
        ]);

        Movie::create([
            'name' => 'Interstellar',
            'date' => '2014-11-07',
            'desc' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.',
        ]);

        Movie::create([
            'name' => 'The Matrix',
            'date' => '1999-03-31',
            'desc' => 'A computer programmer discovers that reality as he knows it is a simulation created by machines.',
        ]);
    }
}

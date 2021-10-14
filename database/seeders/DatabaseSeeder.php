<?php

namespace Database\Seeders;

use Cog\Laravel\Love\ReactionType\Models\ReactionType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    private array $loveReactionTypes = [
        [
            'name' => 'Like',
            'mass' => 1
        ],
        [
            'name' => 'Dislike',
            'mass' => -1
        ],
        [
            'name' => 'Unfollow',
            'mass' => -1
        ],
        [
            'name' => 'Follow',
            'mass' => 1
        ],
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->loveReactionTypes as $rt){

            ReactionType::create([
                'name' => $rt['name'],
                'mass' => $rt['mass']
            ]);

        }
    }
}

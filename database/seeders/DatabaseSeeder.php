<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Species;
use App\Models\Habitat;
use App\Models\Enclosure;
use App\Models\Animal;
use App\Models\AnimalImage;
use App\Models\FeedingSchedule;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles/permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $adminRole   = Role::firstOrCreate(['name' => 'admin']);
        $staffRole   = Role::firstOrCreate(['name' => 'staff']);
        $visitorRole = Role::firstOrCreate(['name' => 'visitor']);

        // Create default users
        $admin = User::firstOrCreate(['email' => 'admin@zoo.com'], [
            'name'     => 'Zoo Admin',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);
        $admin->assignRole('admin');

        $staff = User::firstOrCreate(['email' => 'staff@zoo.com'], [
            'name'     => 'Zoo Staff',
            'password' => Hash::make('password'),
            'role'     => 'staff',
        ]);
        $staff->assignRole('staff');

        $visitor = User::firstOrCreate(['email' => 'visitor@zoo.com'], [
            'name'     => 'Zoo Visitor',
            'password' => Hash::make('password'),
            'role'     => 'visitor',
        ]);
        $visitor->assignRole('visitor');

        // Species
        $mammals    = Species::firstOrCreate(['name' => 'Mammalia'],   ['class' => 'mammal',   'description' => 'Warm-blooded vertebrates with hair or fur.']);
        $reptiles   = Species::firstOrCreate(['name' => 'Reptilia'],   ['class' => 'reptile',  'description' => 'Cold-blooded vertebrates with scales.']);
        $birds      = Species::firstOrCreate(['name' => 'Aves'],       ['class' => 'bird',     'description' => 'Feathered, warm-blooded vertebrates capable of flight.']);
        $fish       = Species::firstOrCreate(['name' => 'Actinopterygii'], ['class' => 'fish', 'description' => 'Ray-finned fishes — the largest group of vertebrates.']);
        $amphibians = Species::firstOrCreate(['name' => 'Amphibia'],   ['class' => 'amphibian','description' => 'Cold-blooded vertebrates that live on land and in water.']);

        // Habitats
        $savanna    = Habitat::firstOrCreate(['name' => 'Savanna'],    ['region' => 'Sub-Saharan Africa',   'climate' => 'Tropical',    'description' => 'Vast grasslands dotted with acacia trees under blazing African skies.']);
        $arctic     = Habitat::firstOrCreate(['name' => 'Arctic'],     ['region' => 'Polar Regions',        'climate' => 'Polar',       'description' => 'Ice-covered expanse with extreme cold and perpetual winter wildlife.']);
        $rainforest = Habitat::firstOrCreate(['name' => 'Rainforest'], ['region' => 'Amazon & South-East Asia', 'climate' => 'Tropical', 'description' => 'Dense canopy of biodiversity teeming with exotic life.']);
        $ocean      = Habitat::firstOrCreate(['name' => 'Ocean'],      ['region' => 'Global Oceans',        'climate' => 'Marine',      'description' => 'Deep blue realm covering 71% of Earth\'s surface.']);
        $desert     = Habitat::firstOrCreate(['name' => 'Desert'],     ['region' => 'Sahara & Middle East', 'climate' => 'Arid',        'description' => 'Harsh, sun-scorched terrain where only the toughest thrive.']);

        // Enclosures (one or two per habitat)
        $savannaEnc    = Enclosure::firstOrCreate(['name' => 'Savanna Plains'],    ['habitat_id' => $savanna->id,    'capacity' => 10, 'location_on_map' => 'A1']);
        $arcticEnc     = Enclosure::firstOrCreate(['name' => 'Polar Tundra'],      ['habitat_id' => $arctic->id,     'capacity' => 6,  'location_on_map' => 'B1']);
        $rainforestEnc = Enclosure::firstOrCreate(['name' => 'Jungle Canopy'],     ['habitat_id' => $rainforest->id, 'capacity' => 12, 'location_on_map' => 'C1']);
        $oceanEnc      = Enclosure::firstOrCreate(['name' => 'Deep Blue Aquarium'],['habitat_id' => $ocean->id,      'capacity' => 8,  'location_on_map' => 'D1']);
        $desertEnc     = Enclosure::firstOrCreate(['name' => 'Arid Sands'],        ['habitat_id' => $desert->id,     'capacity' => 8,  'location_on_map' => 'E1']);
        $savannaEnc2   = Enclosure::firstOrCreate(['name' => 'Acacia Grove'],      ['habitat_id' => $savanna->id,    'capacity' => 8,  'location_on_map' => 'A2']);
        $rainforestEnc2= Enclosure::firstOrCreate(['name' => 'Bamboo Forest'],     ['habitat_id' => $rainforest->id, 'capacity' => 6,  'location_on_map' => 'C2']);
        $arcticEnc2    = Enclosure::firstOrCreate(['name' => 'Ice Shelf'],         ['habitat_id' => $arctic->id,     'capacity' => 10, 'location_on_map' => 'B2']);

        // Animals with realistic data
        $animalData = [
            ['name' => 'African Lion',      'slug' => 'african-lion',      'species_id' => $mammals->id,    'enclosure_id' => $savannaEnc->id,     'age' => 7,  'gender' => 'male',   'weight_kg' => 190,   'height_cm' => 120, 'diet' => 'Carnivore',   'conservation_status' => 'Vulnerable',           'description' => 'The king of the savanna, the African Lion is the only truly social big cat. Males are distinguished by their magnificent manes.',               'fun_fact' => 'A lion\'s roar can be heard from 8 kilometres away!',                                   'arrival_date' => '2019-03-15', 'is_featured' => true,  'thumbnail' => 'animals/lion.jpg'],
            ['name' => 'Bengal Tiger',      'slug' => 'bengal-tiger',      'species_id' => $mammals->id,    'enclosure_id' => $rainforestEnc->id,   'age' => 5,  'gender' => 'female', 'weight_kg' => 160,   'height_cm' => 95,  'diet' => 'Carnivore',   'conservation_status' => 'Endangered',           'description' => 'The largest wild cat species, Bengal Tigers are powerful predators found in the dense forests of India and Bangladesh.',                       'fun_fact' => 'Tigers are excellent swimmers and love to cool off in pools and streams.',               'arrival_date' => '2020-06-22', 'is_featured' => true,  'thumbnail' => 'animals/tiger.jpg'],
            ['name' => 'African Elephant',  'slug' => 'african-elephant',  'species_id' => $mammals->id,    'enclosure_id' => $savannaEnc->id,     'age' => 12, 'gender' => 'female', 'weight_kg' => 5000,  'height_cm' => 300, 'diet' => 'Herbivore',   'conservation_status' => 'Vulnerable',           'description' => 'The world\'s largest land animal. African Elephants have remarkable intelligence and strong family bonds led by a matriarch.',                 'fun_fact' => 'Elephants are one of the few animals that can recognise themselves in a mirror.',        'arrival_date' => '2018-09-10', 'is_featured' => true,  'thumbnail' => 'animals/elephant.jpg'],
            ['name' => 'Polar Bear',        'slug' => 'polar-bear',        'species_id' => $mammals->id,    'enclosure_id' => $arcticEnc->id,      'age' => 9,  'gender' => 'male',   'weight_kg' => 450,   'height_cm' => 150, 'diet' => 'Carnivore',   'conservation_status' => 'Vulnerable',           'description' => 'Built for life in the Arctic, Polar Bears are the world\'s largest land carnivore. Their white fur provides camouflage in the snow.',        'fun_fact' => 'A polar bear\'s fur is actually transparent, not white — it reflects light to appear white.',    'arrival_date' => '2021-01-05', 'is_featured' => true,  'thumbnail' => 'animals/polar_bear.jpg'],
            ['name' => 'Giant Panda',       'slug' => 'giant-panda',       'species_id' => $mammals->id,    'enclosure_id' => $rainforestEnc2->id,  'age' => 6,  'gender' => 'female', 'weight_kg' => 100,   'height_cm' => 80,  'diet' => 'Herbivore',   'conservation_status' => 'Vulnerable',           'description' => 'One of the world\'s most beloved animals, Giant Pandas spend up to 14 hours a day eating bamboo in their mountain forest homes in China.',    'fun_fact' => 'Giant Pandas eat up to 38kg of bamboo every single day.',                               'arrival_date' => '2022-04-18', 'is_featured' => true,  'thumbnail' => 'animals/panda.jpg'],
            ['name' => 'Blue Whale',        'slug' => 'blue-whale',        'species_id' => $mammals->id,    'enclosure_id' => $oceanEnc->id,       'age' => 35, 'gender' => 'female', 'weight_kg' => 150000,'height_cm' => 2800,'diet' => 'Filter Feeder','conservation_status' => 'Endangered',          'description' => 'The largest animal ever known to have existed on Earth. Blue Whales can be found in all oceans and are known for their hauntingly beautiful songs.', 'fun_fact' => 'A blue whale\'s heart is about the size of a small car and weighs around 400kg.',       'arrival_date' => '2023-07-01', 'is_featured' => true,  'thumbnail' => 'animals/whale.jpg'],
            ['name' => 'King Cobra',        'slug' => 'king-cobra',        'species_id' => $reptiles->id,   'enclosure_id' => $desertEnc->id,      'age' => 4,  'gender' => 'male',   'weight_kg' => 6,     'height_cm' => 400, 'diet' => 'Carnivore',   'conservation_status' => 'Vulnerable',           'description' => 'The world\'s longest venomous snake, the King Cobra can spread its neck ribs to form a hood when threatened.',                                'fun_fact' => 'The King Cobra is the only snake that builds a nest for its eggs.',                     'arrival_date' => '2021-11-20', 'is_featured' => false, 'thumbnail' => 'animals/cobra.jpg'],
            ['name' => 'Bald Eagle',        'slug' => 'bald-eagle',        'species_id' => $birds->id,      'enclosure_id' => $savannaEnc2->id,    'age' => 8,  'gender' => 'male',   'weight_kg' => 5.5,   'height_cm' => 90,  'diet' => 'Carnivore',   'conservation_status' => 'Least Concern',        'description' => 'America\'s national bird and symbol, the Bald Eagle is a powerful raptor found near large bodies of open water.',                             'fun_fact' => 'Bald Eagles can see up to 4 times farther than humans.',                                'arrival_date' => '2019-08-30', 'is_featured' => false, 'thumbnail' => 'animals/eagle.jpg'],
            ['name' => 'Snow Leopard',      'slug' => 'snow-leopard',      'species_id' => $mammals->id,    'enclosure_id' => $arcticEnc2->id,     'age' => 4,  'gender' => 'female', 'weight_kg' => 45,    'height_cm' => 65,  'diet' => 'Carnivore',   'conservation_status' => 'Vulnerable',           'description' => 'Masters of camouflage in the Himalayas, Snow Leopards are elusive big cats with beautiful spotted coats adapted for cold climates.',           'fun_fact' => 'Snow Leopards cannot roar. Instead, they make a chuffing sound called "prusten".',      'arrival_date' => '2022-02-14', 'is_featured' => false, 'thumbnail' => 'animals/snow_leopard.jpg'],
            ['name' => 'Komodo Dragon',     'slug' => 'komodo-dragon',     'species_id' => $reptiles->id,   'enclosure_id' => $desertEnc->id,      'age' => 15, 'gender' => 'male',   'weight_kg' => 80,    'height_cm' => 30,  'diet' => 'Carnivore',   'conservation_status' => 'Endangered',           'description' => 'The world\'s largest living lizard, Komodo Dragons have powerful claws and venom-delivering saliva that can bring down prey much larger than themselves.', 'fun_fact' => 'Komodo Dragons can run at speeds up to 20 km/h over short distances.',                  'arrival_date' => '2020-05-03', 'is_featured' => false, 'thumbnail' => 'animals/komodo.jpg'],
            ['name' => 'Gorilla',           'slug' => 'gorilla',           'species_id' => $mammals->id,    'enclosure_id' => $rainforestEnc->id,   'age' => 18, 'gender' => 'male',   'weight_kg' => 180,   'height_cm' => 170, 'diet' => 'Herbivore',   'conservation_status' => 'Critically Endangered','description' => 'The largest of the great apes, Gorillas are highly intelligent animals that share 98.3% of their DNA with humans.',                            'fun_fact' => 'Gorillas create a new nest from branches and leaves every single night to sleep in.',   'arrival_date' => '2017-06-12', 'is_featured' => false, 'thumbnail' => 'animals/gorilla.jpg'],
            ['name' => 'Chimpanzee',        'slug' => 'chimpanzee',        'species_id' => $mammals->id,    'enclosure_id' => $rainforestEnc->id,   'age' => 11, 'gender' => 'female', 'weight_kg' => 40,    'height_cm' => 130, 'diet' => 'Omnivore',    'conservation_status' => 'Endangered',           'description' => 'Humankind\'s closest living relatives, sharing 98.7% of our DNA. Chimps use tools, communicate in complex ways and live in highly social groups.', 'fun_fact' => 'Chimpanzees have been observed making and using tools like sticks to fish for termites.', 'arrival_date' => '2018-03-22', 'is_featured' => false, 'thumbnail' => 'animals/chimp.jpg'],
            ['name' => 'Flamingo',          'slug' => 'flamingo',          'species_id' => $birds->id,      'enclosure_id' => $savannaEnc2->id,    'age' => 6,  'gender' => 'female', 'weight_kg' => 3.5,   'height_cm' => 120, 'diet' => 'Filter Feeder','conservation_status' => 'Least Concern',       'description' => 'Flamingos are famous for their pink plumage and one-legged stance. They live in large flocks around alkaline lakes and lagoons.',              'fun_fact' => 'Flamingos get their pink colour from the pigments in the algae and shrimp they eat.',   'arrival_date' => '2023-01-08', 'is_featured' => false, 'thumbnail' => 'animals/flamingo.jpg'],
            ['name' => 'Nile Crocodile',    'slug' => 'nile-crocodile',    'species_id' => $reptiles->id,   'enclosure_id' => $savannaEnc->id,     'age' => 30, 'gender' => 'male',   'weight_kg' => 750,   'height_cm' => 50,  'diet' => 'Carnivore',   'conservation_status' => 'Least Concern',        'description' => 'One of the most feared predators in Africa, the Nile Crocodile is the continent\'s largest reptile and has remained virtually unchanged for 200 million years.', 'fun_fact' => 'Nile Crocodiles have the strongest bite force ever recorded in any living animal.',      'arrival_date' => '2016-09-25', 'is_featured' => false, 'thumbnail' => 'animals/crocodile.jpg'],
            ['name' => 'Red Fox',           'slug' => 'red-fox',           'species_id' => $mammals->id,    'enclosure_id' => $desertEnc->id,      'age' => 3,  'gender' => 'female', 'weight_kg' => 7,     'height_cm' => 45,  'diet' => 'Omnivore',    'conservation_status' => 'Least Concern',        'description' => 'The cunning Red Fox is the world\'s most widely distributed wild carnivore, adaptable enough to thrive in everything from arctic tundra to city streets.', 'fun_fact' => 'Red Foxes use the Earth\'s magnetic field to help them hunt — a rare ability in mammals.',  'arrival_date' => '2024-03-10', 'is_featured' => false, 'thumbnail' => 'animals/fox.jpg'],
            ['name' => 'Penguin',           'slug' => 'penguin',           'species_id' => $birds->id,      'enclosure_id' => $arcticEnc->id,      'age' => 5,  'gender' => 'male',   'weight_kg' => 5,     'height_cm' => 80,  'diet' => 'Carnivore',   'conservation_status' => 'Near Threatened',      'description' => 'Flightless birds perfectly adapted for life in water, Penguins are found exclusively in the Southern Hemisphere and are highly social creatures.',  'fun_fact' => 'Penguins can drink seawater — a special gland above their eyes filters out the salt.',   'arrival_date' => '2021-07-19', 'is_featured' => false, 'thumbnail' => 'animals/penguin.jpg'],
            ['name' => 'Giraffe',           'slug' => 'giraffe',           'species_id' => $mammals->id,    'enclosure_id' => $savannaEnc->id,     'age' => 8,  'gender' => 'male',   'weight_kg' => 1200,  'height_cm' => 600, 'diet' => 'Herbivore',   'conservation_status' => 'Vulnerable',           'description' => 'The tallest living terrestrial animal on Earth. Giraffes use their extraordinary height to reach leaves at the tops of acacia trees.',           'fun_fact' => 'Giraffes only sleep for about 30 minutes a day, often in short bursts of less than 5 minutes.', 'arrival_date' => '2019-11-14', 'is_featured' => false, 'thumbnail' => 'animals/giraffe.jpg'],
            ['name' => 'Zebra',             'slug' => 'zebra',             'species_id' => $mammals->id,    'enclosure_id' => $savannaEnc2->id,    'age' => 6,  'gender' => 'female', 'weight_kg' => 350,   'height_cm' => 140, 'diet' => 'Herbivore',   'conservation_status' => 'Near Threatened',      'description' => 'Zebras are iconic African horses whose striking black-and-white stripe patterns are as unique as human fingerprints.',                         'fun_fact' => 'No two zebras have the same stripe pattern — they are completely unique, like fingerprints.', 'arrival_date' => '2020-08-30', 'is_featured' => false, 'thumbnail' => 'animals/zebra.jpg'],
            ['name' => 'Hippo',             'slug' => 'hippo',             'species_id' => $mammals->id,    'enclosure_id' => $savannaEnc->id,     'age' => 14, 'gender' => 'male',   'weight_kg' => 3500,  'height_cm' => 155, 'diet' => 'Herbivore',   'conservation_status' => 'Vulnerable',           'description' => 'Semi-aquatic giants that spend most of their day submerged in rivers and lakes. Despite their size, Hippos are surprisingly fast runners.',      'fun_fact' => 'Hippos produce a natural sunscreen! Their reddish oily secretion acts as a moisturiser and protects their skin from UV rays.', 'arrival_date' => '2017-12-01', 'is_featured' => false, 'thumbnail' => 'animals/hippo.jpg'],
            ['name' => 'Orangutan',         'slug' => 'orangutan',         'species_id' => $mammals->id,    'enclosure_id' => $rainforestEnc2->id,  'age' => 20, 'gender' => 'male',   'weight_kg' => 75,    'height_cm' => 140, 'diet' => 'Omnivore',    'conservation_status' => 'Critically Endangered','description' => 'Orangutans are the only great apes native to Asia. They are highly intelligent and are known for their distinctive reddish-brown hair and long arms.', 'fun_fact' => 'Orangutans make a new sleeping nest high in the trees every single night.', 'arrival_date' => '2018-07-04', 'is_featured' => false, 'thumbnail' => 'animals/orangutan.jpg'],
        ];

        foreach ($animalData as $data) {
            $animal = Animal::firstOrCreate(
                ['slug' => $data['slug']],
                $data
            );

            // Feeding schedules (2-3 per day)
            $schedules = [
                ['feed_time' => '08:00:00', 'food_type' => $this->getFoodType($data['diet']), 'quantity_kg' => round($data['weight_kg'] * 0.02, 1), 'days_of_week' => ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'], 'notes' => 'Morning feed — main meal'],
                ['feed_time' => '13:00:00', 'food_type' => $this->getFoodType($data['diet']), 'quantity_kg' => round($data['weight_kg'] * 0.015, 1), 'days_of_week' => ['Mon','Tue','Wed','Thu','Fri'], 'notes' => 'Afternoon supplemental feed'],
                ['feed_time' => '17:30:00', 'food_type' => $this->getFoodType($data['diet']), 'quantity_kg' => round($data['weight_kg'] * 0.01, 1),  'days_of_week' => ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'], 'notes' => 'Evening feed'],
            ];

            foreach ($schedules as $sched) {
                FeedingSchedule::firstOrCreate(
                    ['animal_id' => $animal->id, 'feed_time' => $sched['feed_time']],
                    array_merge($sched, ['animal_id' => $animal->id])
                );
            }
        }
    }

    private function getFoodType(string $diet): string
    {
        return match ($diet) {
            'Carnivore'    => 'Fresh meat & fish',
            'Herbivore'    => 'Fresh grass, hay & vegetables',
            'Omnivore'     => 'Mixed fruits, vegetables & protein',
            'Filter Feeder'=> 'Shrimp, algae & krill',
            default        => 'Mixed diet',
        };
    }
}

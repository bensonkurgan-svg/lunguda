<?php

namespace Database\Seeders;

use App\Models\Clan;
use App\Models\CulturalItem;
use App\Models\LungudaName;
use App\Models\Monument;
use App\Models\OralTradition;
use App\Models\Person;
use App\Models\Phrase;
use App\Models\Ruler;
use App\Models\User;
use App\Models\Word;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        | Accounts. CHANGE THESE PASSWORDS immediately after first login, or
        | set ADMIN_EMAIL / ADMIN_PASSWORD in the environment before seeding.
        */
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@lunguda.org')],
            [
                'name' => 'Archive Administrator',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'change-me-now')),
                'role' => User::ROLE_SUPERADMIN,
                'email_verified_at' => now(),
            ]
        );

        // --- Clans -------------------------------------------------------
        $clans = collect(['Bobo', 'Kurgan', 'Deele', 'Gwaanda'])->mapWithKeys(fn ($name) => [
            $name => Clan::firstOrCreate(['name' => $name], [
                'description' => "The {$name} clan of the Lunguda people of Jessu.",
                'totem' => null,
            ]),
        ]);

        // --- A small matrilineal sample tree (mother -> child) ----------
        $grandmother = Person::firstOrCreate(['name' => 'Yakubu Daughter (founding mother)'], [
            'clan_id' => $clans['Bobo']->id, 'gender' => 'female', 'birth_year' => 1900, 'status' => 'published',
        ]);
        $mother = Person::firstOrCreate(['name' => 'Ladi'], [
            'clan_id' => $clans['Bobo']->id, 'gender' => 'female', 'mother_id' => $grandmother->id,
            'birth_year' => 1928, 'status' => 'published',
        ]);
        Person::firstOrCreate(['name' => 'Talatu'], [
            'clan_id' => $clans['Bobo']->id, 'gender' => 'female', 'mother_id' => $mother->id,
            'birth_year' => 1955, 'status' => 'published',
        ]);

        // --- Words (one per dialect to show tagging) --------------------
        $words = [
            ['word' => 'mala', 'dialect' => 'Guyuk', 'part_of_speech' => 'noun', 'meaning' => 'water', 'example_sentence' => 'Mala ŋga.', 'example_translation' => 'This is water.'],
            ['word' => 'kʋra', 'dialect' => 'Cerin', 'part_of_speech' => 'noun', 'meaning' => 'house, home'],
            ['word' => 'yaa', 'dialect' => 'Deele', 'part_of_speech' => 'verb', 'meaning' => 'to come'],
            ['word' => 'nʋng', 'dialect' => 'Gwaanda', 'part_of_speech' => 'noun', 'meaning' => 'person'],
            ['word' => 'sɔrɔ', 'dialect' => 'Kɔla', 'part_of_speech' => 'noun', 'meaning' => 'sorghum, guinea-corn'],
        ];
        foreach ($words as $w) {
            Word::firstOrCreate(['word' => $w['word'], 'dialect' => $w['dialect']], array_merge($w, ['status' => 'published']));
        }

        // --- Names -------------------------------------------------------
        foreach ([
            ['name' => 'Kurgan', 'meaning' => 'one who endures', 'gender' => 'male', 'dialect' => 'Guyuk'],
            ['name' => 'Ladi', 'meaning' => 'born on a Sunday', 'gender' => 'female', 'dialect' => 'Guyuk'],
        ] as $n) {
            LungudaName::firstOrCreate(['name' => $n['name']], array_merge($n, ['status' => 'published']));
        }

        // --- Phrases -----------------------------------------------------
        foreach ([
            ['phrase' => 'A na yaa?', 'translation' => 'How are you?', 'category' => 'greetings', 'dialect' => 'Guyuk'],
            ['phrase' => 'Na sanu', 'translation' => 'Thank you', 'category' => 'greetings', 'dialect' => 'Guyuk'],
        ] as $p) {
            Phrase::firstOrCreate(['phrase' => $p['phrase']], array_merge($p, ['status' => 'published']));
        }

        // --- Rulers ------------------------------------------------------
        Ruler::firstOrCreate(['name' => 'Benson Kurgan Bobo'], [
            'title' => 'Founding Chief of Jessu',
            'clan_id' => $clans['Bobo']->id,
            'reign_start' => 1940, 'reign_end' => 1975,
            'biography' => 'Remembered as a unifying leader who organised the farming clans of Jessu.',
            'accomplishments' => 'Established the central market and mediated land between the clans.',
            'vision' => 'A Jessu where every child learns to read and write in Lunguda.',
            'order_index' => 1, 'status' => 'published',
        ]);

        // --- Oral tradition ---------------------------------------------
        OralTradition::firstOrCreate(['title' => 'Why the tortoise has a cracked shell'], [
            'type' => 'story', 'narrator_name' => 'Elder of Jessu', 'dialect' => 'Guyuk',
            'transcript' => 'Long ago, the animals held a feast in the sky…',
            'translation' => 'A folktale explaining the markings on the tortoise\'s shell.',
            'status' => 'published',
        ]);

        // --- Cultural item ----------------------------------------------
        CulturalItem::firstOrCreate(['name' => 'Indigo wrapper'], [
            'category' => 'attire',
            'description' => 'A hand-dyed indigo cloth worn at ceremonies.',
            'significance' => 'Indigo dyeing is a long-held craft; the deeper the blue, the greater the labour and status.',
            'materials' => 'Cotton, indigo dye',
            'status' => 'published',
        ]);

        // --- Monument ----------------------------------------------------
        Monument::firstOrCreate(['name' => 'Lunguda Plateau lookout'], [
            'type' => 'landmark',
            'description' => 'A high point on the volcanic plateau overlooking Jessu.',
            'significance' => 'A gathering place and a marker of the homeland.',
            'latitude' => 9.9333, 'longitude' => 11.6500,
            'status' => 'published',
        ]);
    }
}

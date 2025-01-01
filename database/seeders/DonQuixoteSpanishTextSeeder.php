<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DonQuixoteSpanishTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $lines = Storage::disk('local')->get('don_quixote_spanish.json');
        $lines = json_decode($lines, true)[0];
        foreach ($lines as $line) {
            $line = trim($line); // Remove leading/trailing whitespace
            $line = preg_replace('/\s+/', ' ', $line); // Replace multiple spaces with single space
            $line = preg_replace('/” “/', '“', $line);
            $line = trim($line); // because sometimes it pads with " "
            DB::table('don_quixote_spanish_texts')->insert([
                'text' => $line,
                'text_length' => mb_strlen($line, 'UTF-8'),
                'word_count' => count(explode(' ', $line)),
            ]);
        }
    }
}
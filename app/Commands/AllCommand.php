<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Facades\Storage;

class AllCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'all';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Print all the existing notes.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $savedNotes  = Storage::exists('notes.json')
                     ? json_decode(Storage::get('notes.json'))
                     : [];

        if (empty($savedNotes)) {
            $this->comment('No notes saved.');
        } else {
            $this->info('');
            for ($index = 0; $index < count($savedNotes); $index++) {
                $this->info('  '.($index + 1).'. '.$savedNotes[$index]);
            }
        }
    }

}

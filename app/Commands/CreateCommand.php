<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Facades\Storage;

class CreateCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'create {noteContent* : the content of the command}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create a new note';

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
        $savedNotes  = empty($savedNotes) ? [] : $savedNotes;
        $noteContent = implode($this->argument('noteContent'), ' ');
        
        array_push($savedNotes, $noteContent);
        $this->task('Saving the note "'.$noteContent.'"', function () use ($savedNotes) {
            return Storage::put('notes.json', json_encode($savedNotes));;
        });
    }
    
}

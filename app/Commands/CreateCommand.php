<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

use NoteStorage;

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
        $savedNotes  = NoteStorage::retrieve();
        $noteContent = implode($this->argument('noteContent'), ' ');
        
        array_push($savedNotes, [
            'content' => $noteContent,
            'done'    => false
        ]);
        $this->task('Saving the note "'.$noteContent.'"', function () use ($savedNotes) {
            NoteStorage::save($savedNotes);
        });
    }
    
}

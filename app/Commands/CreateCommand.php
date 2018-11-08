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
    protected $signature = 'create {--tag=general : The tag of the note} {noteContent* : the content of the command}';

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
        $tag         = empty($this->option('tag')) ? 'general' : $this->option('tag');

        // find last id
        $id = 0;
        foreach ($savedNotes as $note) {
            if ($note->id >= $id) {
                $id = $note->id + 1;
            }
        }
        
        array_push($savedNotes, [
            'content' => $noteContent,
            'done'    => false,
            'tag'     => $tag,
            'id'      => $id
        ]);
        $this->task('Saving the note "'.$noteContent.'"', function () use ($savedNotes) {
            NoteStorage::save($savedNotes);
        });
    }
    
}

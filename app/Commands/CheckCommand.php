<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

use NoteStorage;

class CheckCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'check {id : the id of the note to check}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Check a note';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $savedNotes  = NoteStorage::retrieve(); 
        $id          = intval($this->argument('id'));
        $found       = false;
        $noteContent = "";

        for ($index = 0; $index < count($savedNotes) && !$found; $index++) {
            if ($savedNotes[$index]->id == $id) {
                $savedNotes[$index]->done = true;
                $found = true;
                $noteContent = $savedNotes[$index]->content;
            }
        }

        if (!$found) {
            $this->comment('No note found with the id '.$this->argument('id'));
        } else {
            $this->task('Checking the note "'.$noteContent.'"', function () use ($savedNotes) {
                NoteStorage::save($savedNotes); 
            });
        }
    }

}

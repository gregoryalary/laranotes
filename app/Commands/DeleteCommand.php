<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

use NoteStorage;

class DeleteCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'delete {id : the id of the note to uncheck}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Delete an exisiting note.';

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
        $deleteIndex = -1;
        $noteContent = "";

        for ($index = 0; $index < count($savedNotes) && !$found; $index++) {
            if ($savedNotes[$index]->id == $id) {
                $savedNotes[$index]->done = true;
                $found = true;
                $noteContent = $savedNotes[$index]->content;
                $deleteIndex = $index;
            }
        }

        if (!$found) {
            $this->comment('No note found with the id '.$this->argument('id'));
        } else {
            array_splice($savedNotes, $deleteIndex, 1);
            $this->task('Deleting the note "'.$noteContent.'"', function () use ($savedNotes) {
                NoteStorage::save($savedNotes); 
            });
        }
    }

}

<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

use NoteStorage;

class UncheckCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'uncheck {id : the id of the note to uncheck}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Uncheck a note';

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
                $savedNotes[$index]->done = false;
                $found = true;
                $noteContent = $savedNotes[$index]->content;
            }
        }

        if (!$found) {
            $this->comment('No note found with the id '.$this->argument('id'));
        } else {
            $this->task('Unchecking the note "'.$noteContent.'"', function () use ($savedNotes) {
                NoteStorage::save($savedNotes); 
            });
        }
    }

}

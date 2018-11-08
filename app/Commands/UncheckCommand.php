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
        $savedNotes = NoteStorage::retrieve(); 
        $id         = intval($this->argument('id')) - 1;
        if ($id < 0 || $id >= count($savedNotes)) {
            $this->comment('No note found with the id '.$this->argument('id'));
        } else {
            $savedNotes[$id]->done = false;
            $this->task('Unchecking the note "'.$savedNotes[$id]->content.'"', function () use ($savedNotes) {
                NoteStorage::save($savedNotes); 
            });
        }
    }

}

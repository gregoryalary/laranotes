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
        $savedNotes = NoteStorage::retrieve(); 
        $id         = intval($this->argument('id')) - 1;
        if ($id < 0 || $id >= count($savedNotes)) {
            $this->comment('No note found with the id '.$this->argument('id'));
        } else {
            $savedNotes[$id]->done = true;
            $this->task('Checking the note "'.$savedNotes[$id]->content.'"', function () use ($savedNotes) {
                NoteStorage::save($savedNotes); 
            });
        }
    }

}

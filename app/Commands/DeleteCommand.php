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
    protected $signature = 'delete';

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
        $savedNotes = NoteStorage::retrieve(); 

        $option = $this->menu('Delete menu', array_column($savedNotes, 'content'))->open();

        if (isset($option)) {
            array_splice($savedNotes, $option, 1);
            $this->task('Re-indexing the notes', function () use ($savedNotes) {
                NoteStorage::save($savedNotes); 
            });
        }  
    }

}

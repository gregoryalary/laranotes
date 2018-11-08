<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Facades\Storage;

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
        $savedNotes  = Storage::exists('notes.json')
                     ? json_decode(Storage::get('notes.json'))
                     : [];
        $savedNotes  = empty($savedNotes) ? [] : $savedNotes;

        $option = $this->menu('Delete menu', $savedNotes)->open();

        if (isset($option)) {
            array_splice($savedNotes, $option, 1);
            $this->task('Re-indexing the notes', function () use ($savedNotes) {
                return Storage::put('notes.json', json_encode($savedNotes));;
            });
        }  
    }

}

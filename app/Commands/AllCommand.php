<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

use NoteStorage;

class AllCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'all';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Print all the existing notes.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $savedNotes = NoteStorage::retrieve();
        $tags       = array_unique(array_column($savedNotes, 'tag'));
        $sortedTags = array_fill_keys($tags, []);

        foreach ($tags as $tag) {
            for ($notesIndex = 0; $notesIndex < count($savedNotes); $notesIndex++) {
                if ($savedNotes[$notesIndex]->tag === $tag) {
                    array_push($sortedTags[$tag], json_decode(json_encode($savedNotes[$notesIndex])));
                }
            }
        }

        if (empty($savedNotes)) {
            $this->comment('No notes saved.');
        } else {
            $this->line('');
            foreach ($sortedTags as $tag => $notes) {
                $this->comment('  '.$tag.' :');
                foreach ($notes as $note) {
                    if ($note->done) {
                        $this->info('    '.$note->id.'. ✓ '.$note->content);
                    } else {
                        $this->info('    '.$note->id.'. □ '.$note->content);
                    }
                }
                $this->line('');
            }
        }
    }

}

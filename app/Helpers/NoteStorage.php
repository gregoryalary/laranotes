<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class NoteStorage
{

    private static $lastId;

    public static function retrieve()
    {
        $savedNotes = Storage::exists('notes.json')
                    ? json_decode(Storage::get('notes.json'))
                    : [];
        return empty($savedNotes) ? [] : $savedNotes;
    }

    public static function save($notes)
    {
        return Storage::put('notes.json', json_encode($notes));
    }

}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Image extends Model
{
    public const IMG_PATH = 'images';

    protected $fillable = [
        'file',
    ];

    public function setFileAttribute($value)
    {
        Storage::exists($value) ? Storage::delete($value) : '';

        $fileName = Str::random(10) . '.' . $value->extension();
        $path = $value->storeAs(
            self::IMG_PATH,
            $fileName
        );
        $this->attributes['file'] = $path;
    }
}

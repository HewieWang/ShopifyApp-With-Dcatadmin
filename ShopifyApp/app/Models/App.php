<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'app';
    public $timestamps = false;
    
    public function getTagsAttribute($value)
    {
        return explode(',', $value);
    }

    public function setTagsAttribute($value)
    {
        $this->attributes['tags'] = implode(',', $value);
    }

}

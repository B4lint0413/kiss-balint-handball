<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    use HasFactory;

    protected $hidden = ['pivot'];
    public $timestamps = false;
    protected $fillable = ['name', 'position', 'nationality', 'date_of_birth', 'number', 'height'];

    public function teams() : BelongsToMany{
        return $this->belongsToMany(Team::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'prefix'];

    // A scope to retrieve a counter by its key
    public function scopeByKey($query, $key)
    {
        return $query->where('key', $key);
    }

    // A method to increment the counter value
    public function incrementValue()
    {
        $this->update(['value' => $this->value + 1]);
    }
}

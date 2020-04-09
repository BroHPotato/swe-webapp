<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = ['threshold', 'type', 'deleted', 'entity', 'sensor', 'lastSent', 'alertId'];
    private $relType = ['minore di', 'maggiore di'];


    public function getType()
    {
        return $this->relType[$this->type];
    }
}

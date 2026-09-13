<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * The database has no foreign key here. Only this relationship reveals that
 * actor_id names a person.
 */
class AuditEntry extends Model
{
    protected $fillable = ['actor_id', 'action'];

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}

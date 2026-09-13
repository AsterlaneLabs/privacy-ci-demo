<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Holds an email address and has no link to any user. */
class NewsletterSignup extends Model
{
    protected $fillable = ['email', 'source'];
}

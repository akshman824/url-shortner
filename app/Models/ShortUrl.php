<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    use HasFactory;

    // Define the table name if it's different from the plural form of the model name
    protected $table = 'short_urls';

    // Define the fields that are mass assignable
    protected $fillable = ['long_url', 'short_url', 'team_id'];
}

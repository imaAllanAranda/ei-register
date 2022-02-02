<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $fillable = [
    //     'memo_date',
    //     'memo_num',
    //     'recipient',
    //     'recipient_company',
    //     'recipient_address',
    //     'subject',
    //     'content',
    //     'name_of_writer',
    //     'position_of_writer',
    //     'signature_of_writer',
    // ];
}

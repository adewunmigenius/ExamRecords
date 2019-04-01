<?php
/**
 * Created by PhpStorm.
 * User: Ahmed
 * Date: 3/31/19
 * Time: 9:05 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;
//    protected $table = 'question';

    protected $fillable = [
        'question', 'op_one', 'op_two', 'op_three', 'op_four', 'op_five', 'answer'
    ];
}
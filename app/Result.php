<?php
/**
 * Created by PhpStorm.
 * User: Ahmed
 * Date: 3/31/19
 * Time: 4:55 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'correct_questions', 'total_questions',
    ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
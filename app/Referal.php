<?php
/**
 * Created by PhpStorm.
 * User: jc
 * Date: 19.10.16
 * Time: 17:24
 */

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Referal extends Model
{
    use Notifiable;

    protected $table = "referal";
    protected $fillable = [
        'inviter_id', 'link_one', 'time_one', 'link_two', 'time_two'
    ];

    public $timestamps = false;
    public $primaryKey = false;

//    public function checkInviter($id) {
//        return !is_null($this->(('inviter_id', '=', $id)->first());
//    }
}
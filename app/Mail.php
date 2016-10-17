<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Mail
 *
 * @mixin \Eloquent
 * @property integer $id
 * @property string $to
 * @property string $from
 * @property string $subject
 * @property string $text
 * @property string $img
 * @property boolean $group
 * @property boolean $send
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Mail whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Mail whereTo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Mail whereFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Mail whereSubject($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Mail whereText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Mail whereImg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Mail whereGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Mail whereSend($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Mail whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Mail whereUpdatedAt($value)
 * @property string $title
 * @property integer $count
 * @method static \Illuminate\Database\Query\Builder|\App\Mail whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Mail whereCount($value)
 */
class Mail extends Model
{
    protected $table = 'mails';
    protected $fillable = ['id', 'to', 'from', 'title', 'subject', 'text', 'img', 'group', 'send', 'count'];
}

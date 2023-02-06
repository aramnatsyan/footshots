<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCoinTransaction extends Model
{
    use SoftDeletes;

    protected $fillable = [ 'debit', 'credit', 'type','user_pending_coin_id', 'account_holder', 'sender_receiver', 'created_at', 'updated_at', 'deleted_at' ];   
}

<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	protected $primaryKey = 'user_id';
    public $timestamps = false;
    public static $rules = array(
        'name' => 'required|between:5,30',
        'email' => 'required|email|max:30|unique:users,email',
        'username' => 'required|alpha|max:20|unique:users,username',
        'password' => 'required|alpha_num|between:6,12|confirmed',
        'password_confirmation' => 'required|alpha_num|between:6,12'
    );

    public function campaign()
    {
        return $this->hasMany('Campaign', 'campaign_id', 'campaign_id');
    }

}

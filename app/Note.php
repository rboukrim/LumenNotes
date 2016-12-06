<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model {
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['title', 'note', 'user_id',];
	
	/**
	 * The attributes that are guarded.
	 *
	 * @var array
	 */
	protected $guarded =  ['id',];

	// DEFINE RELATIONSHIPS
	public function user() {
		return $this->belongsTo('User');
	}
	 
}
?>
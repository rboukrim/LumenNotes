<?php namespace App;
  
use Illuminate\Database\Eloquent\Model;
  
class Note extends Model {
     
     protected $fillable = ['title', 'note', 'user_id'];
    
    // DEFINE RELATIONSHIPS 
    public function user() {
        return $this->belongsTo('User');
    }
     
}
?>
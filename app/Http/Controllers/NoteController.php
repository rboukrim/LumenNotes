<?php
  
namespace App\Http\Controllers;
  
use App\Note;
use App\Http\Controllers\Controller;
    
class NoteController extends Controller {
    
    public function index() {
        return response()->json('list of notes retrieved');
    }
  
    public function getNote($id) {
        return response()->json('note retrieved by id'); 
    }
  
    public function createNote() {
        return response()->json('note created');
    }
    
    public function updateNote($id) {
        return response()->json('note updated');
    }
  
    public function deleteNote( $id){
        return response()->json('note deleted');
    }  
}
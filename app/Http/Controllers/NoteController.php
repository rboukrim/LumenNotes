<?php

namespace App\Http\Controllers;

use App\Note;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class NoteController extends Controller {
    
    public function index(Request $request) {
        $notes = Note::where('user_id', $request->user()->id)->get();
        return response()->json($notes);
    }
  
    public function getNote($id) {
        $note = Note::find($id);
        $checkResponse = $this->checkNoteUserAccess($note);
        if ($checkResponse) {
            return $checkResponse;
        }
        return response()->json($note); 
    }
  
    public function createNote(Request $request) {
    	$userId = $request->user()->id;
    	$requestArr = $request->all();
    	$requestArr['user_id'] = $userId;
        $note = Note::create($requestArr);
        return response()->json($note);
    }
    
    public function updateNote(Request $request, $id) {
        $note = Note::find($id);
        $checkResponse = $this->checkNoteUserAccess($note);
        if ($checkResponse) {
            return $checkResponse;
        }
        $note->title = $request->input('title');
        if ($request->input('note')) {
            $note->note = $request->input('note');
        }
        $note->save();
        return response()->json($note);
    }
  
    public function deleteNote(Request $request, $id){
        $note = Note::find($id);
        $checkResponse = $this->checkNoteUserAccess($note);
        if ($checkResponse) {
            return $checkResponse;
        } 
        $note->delete();
        return response()->json('note deleted');
    }  
    
    private function checkNoteUserAccess($note) {       
        if (!$note) {
            return response()->json(['code' => '404', 'status' => 'Note Not Found'], 404);
        } else if (Gate::denies('note-access', $note)) {
            return response()->json(['code' => '403', 'status' => 'Access denied to note'], 403);
        } 
        return null;
    }
}
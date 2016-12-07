<?php

namespace App\Http\Controllers;

use App\Note;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class NoteController extends Controller {

	/**
	 * Retrieve all notes that belong to an autenticated user.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function index(Request $request) {
		$notes = Note::where('user_id', $request->user()->id)->get();
		return response()->json($notes);
	}

	/**
	 * Retrieve a note by id. The note has to belong to the autenticated user.
	 *
	 * @param  id note id
	 * @return Response
	 */
	public function getNote($id) {
		$note = Note::find($id);
		$checkResponse = $this->checkNoteUserAccess($note);
		if ($checkResponse) {
			return $checkResponse;
		}
		return response()->json($note);
	}

	/**
	 * Store a new note.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function createNote(Request $request) {
		//input validation
		$this->validate($request, [
				'title' => 'required|max:50',
				'note' => 'max:1000',
		]);

		$userId = $request->user()->id;
		$requestArr = $request->all();
		$requestArr['user_id'] = $userId;
		$note = Note::create($requestArr);
		return response()->json($note);
	}

	/**
	 * Update an existing note.
	 *
	 * @param  Request  $request
	 * @param id note id
	 * @return Response
	 */
	public function updateNote(Request $request, $id) {
		//input validation
		$this->validate($request, [
				'title' => 'required|max:50',
				'note' => 'max:1000',
		]);
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

	/**
	 * delete a note.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function deleteNote(Request $request, $id){
		$note = Note::find($id);
		$checkResponse = $this->checkNoteUserAccess($note);
		if ($checkResponse) {
			return $checkResponse;
		}
		$note->delete();
		return response()->json('note deleted');
	}


	/**
	 * Helper mode to check id the authenticated user owns the note, otherwise return an error message
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	private function checkNoteUserAccess($note) {
		if (!$note) {
			return response()->json(['code' => '404', 'status' => 'Note Not Found'], 404);
		} else if (Gate::denies('note-access', $note)) {
			return response()->json(['code' => '403', 'status' => 'Access denied to note'], 403);
		}
		return null;
	}
}
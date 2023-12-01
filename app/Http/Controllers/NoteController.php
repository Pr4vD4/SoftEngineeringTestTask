<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoteResource;
use App\Http\Resources\NoteResourceWithUser;
use App\Http\Resources\UserResource;
use App\Jobs\AdminNotificationJob;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mockery\Matcher\Not;

class NoteController extends Controller
{

    // displays auth user's notes

    public function users_notes()
    {
        return response()->json(NoteResource::collection(Note::query()->where('user_id', Auth::user()->id)->get()));
    }

    // displays notes by user id
    public function user_note(User $user)
    {
        return response()->json(NoteResource::collection($user->notes));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(NoteResourceWithUser::collection(Note::all()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'note_body' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $noteData = $validator->validated();

        if (isset($request->title)) {
            $noteData['title'] = $request->title;
        }

        $noteData['user_id'] = Auth::user()->id;

        $note = Note::create($noteData);
        $note = new NoteResource(Note::find($note->id));

        AdminNotificationJob::dispatch($note, Auth::user()->id);

        return response()->json($note);

    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        //
    }
}

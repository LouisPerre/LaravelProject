<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Inertia\Inertia;

class PlaylistController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        $playlists = Playlist::all();

        return Inertia::render('Playlist/Index', [
            'playlists' => $playlists
        ]);
    }

    /**
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Playlist/Create', [

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required',' string', 'max:100'],
            'description' => ['nullable', 'string', 'max:255'],
            'cover' => ['required', File::types(['png', 'jpg', 'jpeg'])],
            'visibility' => ['required', 'boolean']
        ]);
        $PlaylistCover = Storage::disk('public')->put('playlistCover', $request->file('cover'));


        Playlist::create([
            'name' => $request->name,
            'description' => $request?->description,
            'cover' => $PlaylistCover,
            'visibility'=> $request->visibility,
            'date_of_creation' => new \DateTime(),
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('playlist.index');
    }

    /**
     * @param Playlist $playlist
     * @return \Inertia\Response
     */
    public function show(Playlist $playlist)
    {
        return Inertia::render('Playlist/Show', [
            'playlist' => $playlist->load('musics')
        ]);
    }

    /**
     * @param Playlist $playlist
     * @return \Inertia\Response
     */
    public function edit(Playlist $playlist)
    {
        return Inertia::render('Playlist/Edit', [
            'playlist' => $playlist
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Playlist $playlist)
    {
        if ($request->file('cover')) {
            $request->validate([
                'name' => ['required',' string', 'max:100'],
                'description' => ['nullable', 'string', 'max:255'],
                'cover' => ['required', File::types(['png', 'jpg', 'jpeg'])],
                'visibility' => ['required', 'boolean']
            ]);
            $PlaylistCover = Storage::disk('public')->put('playlistCover', $request->file('cover'));
        } else {
            $request->validate([
                'name' => ['required',' string', 'max:100'],
                'description' => ['nullable', 'string', 'max:255'],
                'cover' => ['required', 'string', 'max:255'],
                'visibility' => ['required', 'boolean']
            ]);
            $PlaylistCover = $request->cover;
        }



        $playlist->update([
            'name' => $request->name,
            'description' => $request?->description,
            'cover' => $PlaylistCover,
            'visibility'=> $request->visibility,
        ]);

        return redirect()->route('playlist.index');
    }

    /**
     * @param Playlist $playlist
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Playlist $playlist)
    {
        $playlist->delete();

        return redirect()->route('playlist.index');
    }
}

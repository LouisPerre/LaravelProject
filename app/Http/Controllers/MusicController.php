<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Music;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\In;
use Inertia\Inertia;
use wapmorgan\Mp3Info\Mp3Info;

class MusicController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        $musics = Music::all();

        return Inertia::render('Music/Index', [
            'musics' => $musics
        ]);
    }

    /**
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Music/Create', [
            'albums' => Album::where('user_id', Auth::user()->id)->get()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required',' string', 'max:100'],
            'album' => ['string', 'nullable'],
            'cover' => ['nullable', File::types(['png', 'jpg', 'jpeg'])],
            'file' => ['required', File::types('mp3')]
        ]);
        $audio = new Mp3Info($request->file('file'));
        $MusicCover = null;
        $duration = gmdate("H:i:s", round($audio->duration));
        if ($request->file('cover')) {
            $MusicCover = Storage::disk('public')->put('cover', $request->file('cover'));
        }
        $MusicFile = Storage::disk('public')->put('music', $request->file('file'));

        Music::create([
            'name' => $request->title,
            'cover' => $MusicCover,
            'length' => $duration,
            'file' => $MusicFile,
            'date_of_creation' => new \DateTime(),
            'user_id' => Auth::user()->id,
            'album_id' => $request?->album
        ]);

        return redirect()->route('music.index');
    }

    /**
     * @param Music $music
     * @return \Inertia\Response
     */
    public function show(Music $music)
    {
        return Inertia::render('Music/Show', [
            'music' => $music->load('album')->load('user')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Music $music)
    {
        return Inertia::render('Music/Edit', [
            'music' => $music->load('album'),
            'albums' => Album::where('user_id', Auth::user()->id)->get()
        ]);
    }

    /**
     * @param Request $request
     * @param Music $music
     * @return void
     */
    public function update(Request $request, Music $music)
    {

        $MusicCover = $music->cover;
        $MusicFile = $music->file;
        $duration = $music->length;
        if ($request->file('file')) {
            $request->validate([
                'title' => ['required',' string', 'max:100'],
                'album' => ['string', 'nullable'],
                'cover' => ['nullable', File::types(['png', 'jpg', 'jpeg'])],
                'file' => ['required', File::types('mp3')]
            ]);
            $audio = new Mp3Info($request->file('file'));
            $MusicFile = Storage::disk('public')->put('music', $request->file('file'));
            $duration = gmdate("H:i:s", round($audio->duration));
        }

        if ($request->file('cover')) {
            $MusicCover = Storage::disk('public')->put('cover', $request->file('cover'));
        }

        if ($request->album) {
            $MusicCover = null;
        }


        $music->update([
            'name' => $request->title,
            'cover' => $MusicCover,
            'length' => $duration,
            'file' => $MusicFile,
            'date_of_creation' => new \DateTime(),
            'user_id' => Auth::user()->id,
            'album_id' => $request?->album
        ]);

        return redirect()->route('music.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Music $music)
    {
        $music->delete();

        return redirect()->route('music.index');
    }
}

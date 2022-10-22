<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Inertia\Inertia;

class AlbumController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        $albums = Album::all();

        return Inertia::render('Album/Index', [
           'albums' => $albums
        ]);
    }

    /**
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Album/Create', [
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
            'cover' => ['required', File::types(['png', 'jpg', 'jpeg'])],
        ]);

        $AlbumCover = Storage::disk('public')->put('albumCover', $request->file('cover'));

        Album::create([
            'name' => $request->name,
            'cover' => $AlbumCover,
            'date_of_creation' => new \DateTime(),
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('album.index');
    }

    /**
     * @param Album $album
     * @return \Inertia\Response
     */
    public function show(Album $album)
    {
        return Inertia::render('Album/Show', [
            'album' => $album
        ]);
    }

    /**
     * @param Album $album
     * @return \Inertia\Response
     */
    public function edit(Album $album)
    {
        return Inertia::render('Album/Edit', [
            'album' => $album
        ]);
    }

    /**
     * @param Request $request
     * @param Album $album
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Album $album)
    {
        if ($request->file('cover')) {
            $request->validate([
                'name' => ['required',' string', 'max:100'],
                'cover' => ['required', File::types(['png', 'jpg', 'jpeg'])],
            ]);
            $AlbumCover = Storage::disk('public')->put('albumCover', $request->file('cover'));

        } else {
            $request->validate([
                'name' => ['required',' string', 'max:100'],
            ]);
            $AlbumCover = $request->cover;

        }

        $album->update([
            'name' => $request->name,
            'cover' => $AlbumCover,
            'date_of_creation' => new \DateTime(),
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('album.index');
    }

    /**
     * @param Album $album
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Album $album)
    {
        $album->delete();

        return redirect()->route('album.index');
    }
}

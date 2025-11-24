<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSongControllerRequest;
use Illuminate\Http\Request;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return \App\Models\Song::with(['artist.user', 'album', 'genre', 'files'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSongControllerRequest $request)
    {
        $request = $request->validated();

        $song = \App\Models\Song::create([
            'artist_id' => $request->artist_id,
            'album_id' => $request->album_id,
            'genre_id' => $request->genre_id,
            'title' => $request->title,
            'duration' => 0, // بعداً با کتابخانه mp3 می‌توان محاسبه کرد
            'status' => 'pending',
        ]);

        // آپلود فایل‌ها
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('songs', 'public'); // مسیر storage/app/public/songs
                \App\Models\SongFile::create([
                    'song_id' => $song->id,
                    'quality' => '320', // می‌تونی از اسم فایل یا input تعیین کنی
                    'file_url' => $path,
                ]);
            }
        }

        return response()->json($song->load('files'), 201);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $song = \App\Models\Song::with(['artist.user','album','genre','files'])->findOrFail($id);
        return response()->json($song);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $song = \App\Models\Song::findOrFail($id);
        $song->update($request->only(['title','album_id','genre_id','status']));
        return response()->json($song);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $song = \App\Models\Song::findOrFail($id);
        $song->delete();
        return response()->json(null, 204);
    }
}

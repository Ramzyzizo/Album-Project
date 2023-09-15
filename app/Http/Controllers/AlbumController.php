<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use App\Rules\ArraySpace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('album.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'album_name' => ['required', 'string', 'max:255'],
            'images' => ['required'],
            'image_names' => [new ArraySpace],// ArraySpace to check every name is not empty or space
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
//            return $request;
            $images = $request->images;
            $image_names = $request->image_names;
            $user = auth()->user();
            $album = new Album;
            $album->name = $request->album_name;
            $album->user_id = $user->id;
            $album->save();

            foreach ($image_names as $i => $img_name ){
                $photo = new Photo;
                $photo->name=$img_name;
                $photo->album_id=$album->id;
                $photo->path = $request->file('images')[$i]->store('images');
                $photo->save();
            }
            return redirect()->route('album.create')
                ->with('success','Album is created successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user =auth()->user();
        $album = Album::find($id);
        $albums = $user->albums;
        return view('album.show',compact('album','albums'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $album = Album::find($id);
        return view('album.edit',compact('album'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'album_name' => ['required', 'string', 'max:255'],
            'images.*' => ['nullable', 'image', 'max:2048'],
            'image_names' => [new ArraySpace],// ArraySpace to check every name is not empty or space
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
            $album = Album::find($id);
            $album->update(['name'=>$request->album_name]);

            $images_ids = $request->images_ids;
            $images = $request->file('images');
            $old_photo_ids= Photo::where('album_id',$album->id)->select('id')->pluck('id')->toArray();
            if ($images_ids !=null) {
                foreach ($old_photo_ids as $old_id) {
                    if (!in_array($old_id, $images_ids)) {
                        $path = Photo::find($old_id)->select('path')->first();
                        Storage::delete($path['path']);
                        Photo::find($old_id)->delete();
                    }
                }
                foreach ($images_ids as $index => $img_id) {
                    if ($img_id != 'na') {
                        $photo = Photo::find($img_id);
                        if (isset($images[$index])) {
                            Storage::delete($photo['path']);
                            $photo->path = $request->file('images')[$index]->store('images');
                        }
                        $photo->name = $request->image_names[$index];
                        $photo->save();
                    } else {
                        $photo = new Photo;
                        $photo->name = $request->image_names[$index];
                        $photo->album_id = $album->id;
                        $photo->path = $request->file('images')[$index]->store('images');
                        $photo->save();
                    }
                }
                return redirect()->route('home')
                    ->with('success', 'Album is updated successfully');
            }else{
                $photos = Photo::where('album_id',$album->id)->get();
                foreach ($photos as $photo){
                    Storage::delete($photo->path);
                    Photo::find($photo->id)->delete();
                }
                return redirect()->route('home')
                    ->with('success', 'Album is updated successfully');
            }

        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $photos=Photo::where('album_id',$request->album_id)->get();
        foreach ($photos as $photo){
            Storage::delete($photo->path);
            Photo::find($photo->id)->delete();
        }
        Album::find($request->album_id)->delete();
        return redirect()->route('home')
            ->with('success', 'Album is deleted successfully');
    }
    public function move(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_album' => ['required']
        ],[
            'new_album.required'=>"You didn't choose album"
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        } else {
        $photos=Photo::where('album_id',$request->album_id)->get();
        foreach ($photos as $photo){
            $photo->album_id=$request->new_album;
            $photo->save();
        }
        Album::find($request->album_id)->delete();
        return redirect()->route('home')
            ->with('success', 'Album is moved successfully');
        }
    }

    public function album_check($id){
        $album = Album::find($id);
        $other_albums = Album::where('id','!=',$id)->get();
        if((count($album->photos)>0)&&(count($other_albums)>0)){
            return response()->json([
                'hasPhotos' => true
            ]);
        }else{
            return response()->json([
                'message' => 'Album not found'
            ], 404);
        }
    }
}

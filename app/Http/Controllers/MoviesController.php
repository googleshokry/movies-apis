<?php

namespace App\Http\Controllers;

use App\Actor;
use App\Movie as Model;
use App\MovieActor;
use Illuminate\Support\Facades\Request;

class MoviesController extends Controller
{

    /**
     * MoviesController constructor.
     */
    public function __construct()
    {
        return parent::__construct();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function get(\Illuminate\Http\Request $request)
    {
        return $this->outPut(['list' => Model::filter($request)->with('actors')->orderBy($request->order??'id')->paginate()], 200, true);
    }

    /**
     * @param null $id
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function save()
    {
        $this->validation(Model::$rules_create);
        $movie = new Model();
        if (empty($this->errors)) {
            // set Data
            $movie->data();
            $movie->save();
            if (\request()->input('actors_list')) {
                Model::AddActors($movie->id);
            }
            // upload Image
            if (!empty(\request()->image_path)) {
                Model::uploadImage($movie->id);
            }
        }
        return $this->outPut(['data' => $movie->with('actors')->where('id',$movie->id)->get()], 200, true);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function edit($id, \Illuminate\Http\Request $request)
    {
        $status = false;
        if ($movie = Model::find($id)) {
            // set Data
            $movie->data();
            $movie->update();
            if (\request()->input('actors_list')) {
                MovieActor::where('movie_id', $movie->id)->delete();
                // create Actors
                Model::AddActors($movie->id);
            }
            // upload Image
            if (!empty(\request()->image_path)) {
                // delete old file
                unlink(public_path($movie->image_path));
                // upload new file
                Model::uploadImage($movie->id);
            }
            return $this->outPut(['data' => $movie->with('actors')->where('id',$id)->get()], 200, true);
        }
        return $this->outPut(['status' => $status], 200, true);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function delete($id)
    {
        $status = false;
        if ($m = Model::find($id)) {
            $status = $m->delete();
            return $this->outPut(['status' => $status]);
        }
        $this->errors[] = "Can't find movie to delete !";
        return $this->outPut(['status' => $status]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function show($id)
    {
        $status = false;
        if ($m = Model::with('actors')->where('id',$id)->get()) {
            return $this->outPut([$m]);
        }
        $this->errors[] = "Can't find movie!";
        return $this->outPut(['status' => $status]);
    }
}

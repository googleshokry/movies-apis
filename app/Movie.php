<?php

namespace App;

use Illuminate\Database\Eloquent\Model as ModelBasic;
use Illuminate\Http\Request;


class Movie extends ModelBasic
{

    protected $table = "movies";
    protected $primaryKey = "id";
    public $timestamps = true;

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($q) {
            unlink(public_path($q->image_path));
        });

    }

    //rules
    public static $rules_edit = [
        "title" => "required|max:255",
        "description" => "required",
        "image_path" => "",
        "rating" => "required|numeric", //(from 0 to 10)
        "genre" => "required", //(multiple values)
        "year" => "required",
        "gross_profi" => "required",
        "director " => "required",
        "actors_list" => "required",
    ];
    public static $rules_create = [
        "title" => "required|max:255",
        "description" => "required",
        "image_path" => "",
        "rating" => "required|numeric", //(from 0 to 10)
        "genre" => "required", //(multiple values)
        "year" => "required",
        "gross_profi" => "required",
        "director " => "",
        "actors_list" => "required",
    ];

    public static function AddActors($movie_id)
    {
        $actors = explode(',',\request()->input('actors_list'));
        foreach ($actors as $actor)
        {
            $act = Actor::firstOrCreate(array('name' => $actor));
            MovieActor::insert(['movie_id'=>$movie_id,'actor_id'=>$act->id]);
        }

    }


    public function scopeFilter($q, Request $request)
    {
        if ($request->title)
            $q->where("title", "like", "%$request->title%");
        if ($request->rating)
            $q->where("rating", "like", "%$request->rating%");
        if ($request->director)
            $q->where("director", "like", "%$request->director%");
        if ($request->year)
            $q->where("year", "like", "%$request->year%");
        if ($request->genre)
            $q->where("genre", "like", "%$request->genre%");
    }
    public static function uploadImage($id)
    {
        $file = \request()->file('image_path');
        $filename = 'Movie-poster-' . $id . '.' . $file->getClientOriginalExtension();

        // save to public/files as the new $filename
        $path = $file->move('files', $filename);
        $mov = self::find($id);
        $mov->image_path = $path;
        $mov->update();
    }
    public function Data()
    {
        if(!empty(\request()->title))$this->title = \request()->input('title');
        if(!empty(\request()->description))$this->description = \request()->input('description');
        if(!empty(\request()->rating))$this->rating = \request()->input('rating');
        if(!empty(\request()->genre ))$this->genre = \request()->input('genre');
        if(!empty(\request()->year))$this->year = \request()->input('year');
        if(!empty(\request()->gross_profi))$this->gross_profi = \request()->input('gross_profi');
        if(!empty(\request()->director))$this->director = \request()->input('director');
    }
    public function actors()
    {
        return $this->hasMany(MovieActor::class)->join('actors','actors.id','=','movie_actor.actor_id');
    }
}

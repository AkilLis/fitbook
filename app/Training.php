<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    //
    protected $primaryKey = 'id';
	protected $table = 'training';

	protected $fillable = [
        'club_id', 'name', 'description','is_active'
    ];

    public function photos()
    {
    	return $this->belongsToMany('App\Photo', 'training_photos', 'training_id', 'photo_id')
    			->withPivot('pinned', 'top', 'left')
    			->withTimestamps();
    }

    public function pinnedPhotos()
    {
        return $this->belongsToMany('App\Photo', 'training_photos', 'training_id', 'photo_id')
                    ->withPivot('pinned', 'top', 'left')
                    ->where('pinned', '=', 'Y');
    }

    public function pinnedPhoto()
    {
        return $this->photos()->where('pinned', '=', 'Y')->get();
    }

    public function teachers()
    {
    	return $this->belongsToMany('App\User', 'training_teacher', 'training_id', 'user_id')
    			->withTimestamps();
    }

    public function firstTwoTeachers()
    {
        return $this->belongsToMany('App\User', 'training_teacher', 'training_id', 'user_id')
                ->orderBy('created_at')
                ->orderBy('id')
                ->limit(2);
    }

    public function genres()
    {
        return $this->belongsToMany('App\Genre', 'training_genre', 'training_id', 'genre_id')
                ->withTimestamps();
    }

    public function histories()
    {
        return $this->belongsToMany('App\User', 'training_adjustments', 'training_id', 'user_id')
                ->withPivot('before', 'after')
                ->withTimestamps();   
    }

    static public function checkNameDuplicate($id, $name)
    {
        return Training::where('name', '=', $name)->
                where('id', '<>' , $id)->exists();
    }
}

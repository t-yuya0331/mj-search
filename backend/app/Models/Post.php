<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'user_id',
        'target',
        'description',
        'date',
        'time',
        'number',
        'location',
        'role_id',
        'status'
    ];


    // Algoria search function
    public function toSearchableArray(){
        $array = $this->toArray();
        $array['number'] = $this->getNumberLabelAttribute();
        $array['target'] = $this->getTargetLabelAttribute();
        unset($array['image']);
        unset($array['updated_at']);
        unset($array['user_id']);

        return $array;
    }

    public function getTargetLabelAttribute(){
        $targetLabels = [
            1 => '初心者',
            2 => '中級者',
            3 => '上級者',
            4 => '誰でも歓迎',
        ];

        return $targetLabels[$this->target] ?? '';
}

    public function getNumberLabelAttribute(){
        $numberLabels = [
            1 => '募集人数1',
            2 => '募集人数2',
            3 => '募集人数3',
        ];

        return $numberLabels[$this->number] ?? '';
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function categoryPost(){
        return $this->hasMany(CategoryPost::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function nices(){
        return $this->hasMany(Nice::class);
    }

    public function isLiked(){
        return $this->nices()->where('user_id',Auth::user()->id)->exists();
    }

}


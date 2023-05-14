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

    protected $appends = ['number_text'];

    // Algoria search function
    public function toSearchableArray(){
        $array = $this->toArray();
        $array['target_text'] = $this->getTargetTextAttribute();
        $array['number_text'] = $this->getNumberTextAttribute();
        unset($array['image']);
        unset($array['updated_at']);

        return $array;
    }
    public function searchableAs(){
        return 'posts_index';
    }
    public function getTargetTextAttribute(){
        switch ($this->target) {
            case 1:
                return '初心者';
            case 2:
                return '中級者';
            case 3:
                return '上級者';
            case 4:
                return '誰でも歓迎';
            default:
                return '';
        }
    }

    public function getNumberTextAttribute(){
        switch ($this->number){
            case 1:
                return '募集人数 1';
            case 2:
                return '募集人数 2';
            case 3:
                return '募集人数 3';
            default:
                return '';
        }
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


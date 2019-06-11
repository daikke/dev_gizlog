<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\User;
use App\Models\TagCategory;

class Question extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'tag_category_id',
        'title',
        'content',
    ];

    protected $date = [
        'deleted_at',
        'created_at',
    ];

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tagCategory()
    {
        return $this->belongsTo(TagCategory::class);
    }

    public function searchQuestions($arrayInputs)
    {
        $query = $this;
        if ($arrayInputs) {
            $searchWord = $arrayInputs['search_word'];
            $tagCategoryId = $arrayInputs['tag_category_id'];
            if($searchWord && $tagCategoryId) {
                $query = $query->where('tag_category_id', $tagCategoryId)
                               ->where('title', 'like', '%'.$searchWord.'%');
            } elseif($searchWord && !$tagCategoryId) {
                $query = $query->where('title', 'like', '%'.$searchWord.'%');
            } elseif(!$searchWord && $tagCategoryId) {
                $query = $query->where('tag_category_id', $tagCategoryId);
            }
        }
        return $query->get();
    }

    public function fetchUserQuestions($userId)
    {
        return $this->where('user_id', $userId)->get();
    }

    public function storeQuestion($validatedArrayInputs)
    {
        $query = $this;
        if(isset($validatedArrayInputs['id'])) {
            $redirectPath = '/question/mypage';
            $query = $query->find($validatedArrayInputs['id']);
        } else {
            $redirectPath = '/question';
            $validatedArrayInputs['user_id'] = Auth::id();
        }
        $query->fill($validatedArrayInputs)->save();
        return $redirectPath;
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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

    public function comments()
    {
        return $this->hasMany(Comment::class, 'question_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

    public function tagCategories()
    {
        return $this->hasMany(TagCategory::class, 'id', 'tag_category_id');
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
}


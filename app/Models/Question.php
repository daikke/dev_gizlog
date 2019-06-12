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

    public function scopeSearchCategory($query, $tagCategoryId)
    {
        return $query->where('tag_category_id', $tagCategoryId);
    }

    public function scopeSearchKeywords($query, $keywords)
    {
        return $query->where('title', 'like', '%' . $keywords . '%');
    }

    public function scopeFetchUserQuestions($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function searchQuestions($request)
    {
        $query = $this->newQuery();
        if ($request->filled('tag_category_id')) {
            $query->searchCategory($request->input('tag_category_id'));
        }
        if ($request->filled('search_word')) {
            $query->searchKeywords($request->input('search_word'));
        }
        return $query->get();
    }

    public function storeQuestion($validatedArrayInputs)
    {
        $query = $this;
        if (isset($validatedArrayInputs['id'])) {
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


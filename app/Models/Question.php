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

    public function scopeSearchCategory($query, $inputs)
    {
        if (!empty($inputs['tag_category_id'])) {
            return $query->where('tag_category_id', $inputs['tag_category_id']);
        }
    }

    public function scopeSearchKeywords($query, $inputs)
    {
        if (!empty($inputs['search_word'])) {
            return $query->where('title', 'like', '%'.$inputs['search_word'].'%');
        }
    }

    public function scopeFetchUserQuestions($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function searchQuestions($inputs)
    {
        return $this->searchCategory($inputs)
                    ->searchKeywords($inputs)
                    ->get();
    }

    public function storeQuestion($validatedInputs, $id)
    {
        $this->updateOrCreate(['id' => $id], $validatedInputs);
    }
}


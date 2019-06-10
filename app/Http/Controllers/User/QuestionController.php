<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\TagCategory;
use App\Models\Comment;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public $question;
    public $tagCategory;
    public $comment;

    public function __construct(Question $question, TagCategory $tagCategory, Comment $comment)
    {
        $this->question = $question;
        $this->tagCategory = $tagCategory;
        $this->comment = $comment;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objectTagCategories = $this->tagCategory->all();
        $objectQuestions = $this->question->all();
        return view('user.question.index', compact('objectTagCategories', 'objectQuestions'));
    }
    /**
     * Display a listing of the searched resouce.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $arrayInputs = $request->all();
        $objectTagCategories = $this->tagCategory->all();
        $objectQuestions = $this->question->searchQuestions($arrayInputs);
        return view('user.question.index', compact('objectTagCategories', 'objectQuestions'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.question.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return view('user.question.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }

    public function myPage($userId)
    {
        return view('user.question.mypage');
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\QuestionsRequest;
use App\Models\Question;
use App\Models\TagCategory;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $objectTagCategories = $this->tagCategory->all();
        return view('user.question.create', compact('objectTagCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionsRequest $request)
    {
        $validatedArrayInputs = $request->validated();
        $validatedArrayInputs['user_id'] = Auth::id();
        $this->question->fill($validatedArrayInputs)->save();
        return redirect()->to('/question');
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
    public function edit($id)
    {
        dd('successedit'.$id);
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
    public function destroy(Request $request)
    {
        $inputs = $request->all();
        dd('successdelete'.$inputs['id']);
    }

    public function myPage()
    {
        $userId = Auth::id();
        $objectQuestions = $this->question->fetchUserQuestions($userId);
        return view('user.question.mypage', compact('objectQuestions'));
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\QuestionsRequest;
use App\Http\Requests\User\CommentRequest;
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
    public function index(Request $request)
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
     * @param  \App\Http\Requests\User\QuestionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionsRequest $request)
    {
        $validatedArrayInputs = $request->all();
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
    public function show($id)
    {
        $objectSelectedQuestion = $this->question->find($id);
        return view('user.question.show', compact('objectSelectedQuestion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $objectTagCategories = $this->tagCategory->all();
        $objectSearchedQuestion = $this->question->find($id);
        return view('user.question.edit', compact('objectSearchedQuestion', 'objectTagCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\User\QuestionsRequest  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionsRequest $request, $id)
    {
        $validatedArrayInputs = $request->all();
        $this->question->find($id)->fill($validatedArrayInputs)->save();
        return redirect()->to('/question/mypage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $arrayInputs = $request->all();
        $this->question->find($arrayInputs['id'])->delete();
        $this->comment->where('question_id', $arrayInputs['id'])->delete();
        return redirect()->to('/question/mypage');
    }

    /**
     * Display a listing of user's questions.
     *
     * @return \Illuminate\Http\Response
     */
    public function myPage()
    {
        $userId = Auth::id();
        $objectQuestions = $this->question->fetchUserQuestions($userId);
        return view('user.question.mypage', compact('objectQuestions'));
    }

    /**
     * Store a newly created comment in storage.
     *
     * @param  \App\Http\Requests\User\CommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function createComment(CommentRequest $request)
    {
        $validatedArrayInputs = $request->all();
        $this->comment->fill($validatedArrayInputs)->save();
        return redirect()->to('question/'.$validatedArrayInputs['question_id'].'/show');
    }


}

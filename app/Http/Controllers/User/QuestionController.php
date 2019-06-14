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
    protected $question;
    protected $tagCategory;
    protected $comment;

    public function __construct(Question $question, TagCategory $tagCategory, Comment $comment)
    {
        $this->middleware('auth');
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
        $tagCategories = $this->tagCategory->all();
        $questions = $this->question->searchQuestions($request);
        return view('user.question.index', compact('tagCategories', 'questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tagCategories = $this->tagCategory->all();
        return view('user.question.create', compact('tagCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\User\QuestionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionsRequest $request)
    {
        $redirectRoute = $request->input('redirectRoute');
        $validatedInputs = $request->all();
        $validatedInputs['user_id'] = Auth::id();
        $this->question->storeQuestion($validatedInputs, $request->input('id'));
        return redirect()->to(route($redirectRoute));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $selectedQuestion = $this->question->find($id);
        return view('user.question.show', compact('selectedQuestion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tagCategories = $this->tagCategory->all();
        $searchedQuestion = $this->question->find($id);
        return view('user.question.edit', compact('searchedQuestion', 'tagCategories'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->question->find($id)->delete();
        $this->comment->where('question_id', $id)->delete();
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
        $questions = $this->question->fetchUserQuestions($userId)->get();
        return view('user.question.mypage', compact('questions'));
    }

    /**
     * Store a newly created comment in storage.
     *
     * @param  \App\Http\Requests\User\CommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function createComment(CommentRequest $request)
    {
        $validatedInputs = $request->all();
        $this->comment->fill($validatedInputs)->save();
        return redirect()->to(route('question.show', ['id' => $validatedInputs['question_id']]));
    }
    /**
     * Display a confirm of create question.
     *
     * @param  \App\Http\Requests\User\QuestionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function confirm(QuestionsRequest $request)
    {
        $validatedInputs = $request->all();
        $validatedInputs['tag_category_name'] = $this->tagCategory
                                                 ->find($validatedInputs['tag_category_id'])
                                                 ->name;
        return view('user.question.confirm', compact('validatedInputs'));
    }
}

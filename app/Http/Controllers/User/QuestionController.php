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



        //$objectQuestions = $this->question->searchQuestions($request->all());


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
        $redirectPath = $this->question->storeQuestion($validatedArrayInputs);
        return redirect()->to($redirectPath);
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
        return redirect()->to(route('question.show', ['id' => $validatedArrayInputs['question_id']]));
    }
    /**
     * Display a confirm of create question.
     *
     * @param  \App\Http\Requests\User\QuestionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function confirm(QuestionsRequest $request)
    {
        $arrayInputs = $request->all();
        $arrayInputs['tag_category_name'] = $this->tagCategory
                                                 ->find($arrayInputs['tag_category_id'])
                                                 ->name;
        return view('user.question.confirm', compact('arrayInputs'));
    }
}

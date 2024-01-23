<?php

namespace Modules\BotQuestion\Http\Admin\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\BotQuestion\Entities\BotQuestion;
use Modules\BotQuestion\Services\BotQuestionService;

class BotQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $questions = BotQuestion::all();
        return view('bot_question::admin.index', compact('questions'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(BotQuestion $question)
    {
        return view('bot_question::admin.edit', \compact('question'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, BotQuestion $question)
    {
        $request->validate([
            'question' => 'required|string|min:3|max:250',
        ]);
        $service  = new BotQuestionService();
        $service->update($question, $request->get('question'));
        return \success_update('bot-question.index');
    }
}
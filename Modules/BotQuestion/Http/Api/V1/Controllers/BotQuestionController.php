<?php

namespace Modules\BotQuestion\Http\Api\V1\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\BotQuestion\Services\BotQuestionService;

class BotQuestionController extends Controller
{
    public function __construct(private BotQuestionService $service)
    {
    }

    public function index()
    {
        // $question = isset($this->service->getAll()[$content]) ? $this->service->getAll()[$content] : null;
        // if (is_null($question))
        //     abort(404);
        return response()->json([
            'data' => $this->service->getAll(),
        ]);
    }

    public function show(string $content)
    {
        return $this->service->get($content);
    }
}
<?php

namespace Modules\BotQuestion\Services;

use Illuminate\Support\Facades\Cache;
use Modules\BotQuestion\Entities\BotQuestion;
use Modules\Category\Services\CategoriesService;
use Modules\City\Entities\City;

class BotQuestionService
{
    /***
     * make validation on the request
     * get neighborhoods of the city
     */
    public function getAll()
    {
        return Cache::rememberForever('bot_questions', function () {
            return BotQuestion::all()->keyBy('content')->toArray();
        });
    }
    public function update(BotQuestion $botQuestion, string $question)
    {
        $botQuestion->update(['question' => $question]);
        Cache::forget('bot_questions');
    }
    public function get(string $content)
    {
        $question = isset($this->getAll()[$content]) ? $this->getAll()[$content] : null;
        if (is_null($question))
            return $this->getResponse(false, __('messages.question_is_not_found'));
        if ($question['type'] == 'select')
            return $this->getOptions($question['content']);
        if ($question['content'] == 'city') {
            \request()->validate([
                'search' => 'required|string|min:2|max:120',
            ]);
            return $this->getSearch(request()->get('search'));
        }
        return $this->getResponse(false, __('messages.content_is_not_found'));
    }
    public function getOptions(string $content)
    {
        $questionContent = [
            'category' => CategoriesService::getAllSimple(),
            'type' => [
                ['id' => 'rent', 'name' => __('admin.ad_type.rent')],
                ['id' => 'sell', 'name' => __('admin.ad_type.sell')],
            ],
        ];
        if ($content == 'neighborhood') {
            \request()->validate([
                'city' => 'required|numeric',
            ]);
            $city = City::select(['id'])->firstWhere('id', request()->get('city'));
            if ($city) {
                $city->load('neighborhoods:id,name,city_id');
                return $this->getResponse(true, 'success', $city->neighborhoods);
            }
            return $this->getResponse(false, __('messages.city_is_not_found'));
        }
        if (isset($questionContent[$content]))
            return $this->getResponse(true, 'success', $questionContent[$content]);
        return $this->getResponse(false, __('messages.content_is_not_found'));
    }
    public function getSearch(string $search)
    {
        $city = City::select(['id', 'name'])->firstWhere('name', 'like', "%$search%");
        if ($city)
            return $this->getResponse(true, 'success', [$city]);

        return $this->getResponse(false, __('messages.city_is_not_found'));
    }
    public function getResponse(bool $status, string $message, $data = [])
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ]);
    }
}
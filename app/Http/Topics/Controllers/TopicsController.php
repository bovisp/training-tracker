<?php

namespace TrainingTracker\Http\Topics\Controllers;

use Illuminate\Http\Request;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Topics\Topic;
use TrainingTracker\Http\Topics\Requests\StoreTopicRequest;
use TrainingTracker\Http\Topics\Requests\UpdateTopicRequest;

class TopicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('topics.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('topics.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTopicRequest $request)
    {
        Topic::create([
            'number' => request('number'),
            'name' => [
                'en' => request('name_en'),
                'fr' => request('name_fr')
            ]
        ]);

        return redirect()
            ->route('topics.index')
            ->with([
                'flash' => [
                    'message' => 'Topic successfully added.'
                ]
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \TrainingTracker\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit(Topic $topic)
    {
        return view('topics.edit', compact('topic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \TrainingTracker\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        $topic->update([
            'number' => request('number'),
            'name' => [
                'en' => request('name_en'),
                'fr' => request('name_fr')
            ]
        ]);

        return redirect()
            ->route('topics.index')
            ->with([
                'flash' => [
                    'message' => 'Topic successfully updated.'
                ]
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \TrainingTracker\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        $topic->delete();

        return redirect()
            ->route('topics.index')
            ->with([
                'flash' => [
                    'message' => 'Topic successfully deleted.'
                ]
            ]);
    }
}

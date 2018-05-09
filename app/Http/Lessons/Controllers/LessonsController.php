<?php

namespace TrainingTracker\Http\Lessons\Controllers;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Lessons\Lesson;
use TrainingTracker\Domains\Topics\Topic;
use TrainingTracker\Http\Lessons\Requests\StoreLessonRequest;
use TrainingTracker\Http\Lessons\Requests\UpdateLessonRequest;

class LessonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('lessons.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $topics = Topic::all();

        return view('lessons.create', compact('topics'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLessonRequest $request)
    {
        Lesson::create([
            'topic_id' => request('topic_id'),
            'number' => request('number'),
            'name' => [
                'en' => request('name_en'),
                'fr' => request('name_fr')
            ],
            'p9' => request()->has('p9') ? request('p9') : 0,
            'p18' => request()->has('p18') ? request('p18') : 0,
            'p30' => request()->has('p30') ? request('p30') : 0,
            'p42' => request()->has('p40') ? request('p40') : 0,
        ]);

        return redirect()
            ->route('lessons.index')
            ->with([
                'flash' => [
                    'message' => 'Lesson successfully added.'
                ]
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \TrainingTracker\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        $topics = Topic::all();

        return view('lessons.edit', compact('lesson', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \TrainingTracker\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $lesson->update([
            'topic_id' => request('topic_id'),
            'number' => request('number'),
            'name' => [
                'en' => request('name_en'),
                'fr' => request('name_fr')
            ],
            'depricated' => request('depricated'),
            'p9' => request()->has('p9') ? request('p9') : 0,
            'p18' => request()->has('p18') ? request('p18') : 0,
            'p30' => request()->has('p30') ? request('p30') : 0,
            'p42' => request()->has('p40') ? request('p40') : 0,
        ]);

        return redirect()
            ->route('lessons.index')
            ->with([
                'flash' => [
                    'message' => 'Lesson successfully updated.'
                ]
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \TrainingTracker\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return redirect()
            ->route('lessons.index')
            ->with([
                'flash' => [
                    'message' => 'Lesson successfully deleted.'
                ]
            ]);
    }
}

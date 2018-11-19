<?php

namespace TrainingTracker\Http\Lessons\Controllers;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Lessons\Lesson;
use TrainingTracker\Domains\Levels\Level;
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
        $levels = Level::all();

        return view('lessons.create', compact('levels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLessonRequest $request, Lesson $lesson)
    {
        $lesson->add();

        return redirect()
            ->route('lessons.index')
            ->with([
                'flash' => [
                    'message' => trans('app.flash.lessonadded');
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
        $levels = Level::all();

        return view('lessons.edit', compact('lesson', 'levels'));
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
        $lesson->edit();

        return redirect()
            ->route('lessons.index')
            ->with([
                'flash' => [
                    'message' => trans('app.flash.lessonupdated');
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
                    'message' => trans('app.flash.lessondeleted');
                ]
            ]);
    }
}

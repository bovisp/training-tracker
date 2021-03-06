<?php

namespace TrainingTracker\Http\Objectives\Controllers;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Lessons\Lesson;
use TrainingTracker\Domains\Objectives\Objective;
use TrainingTracker\Http\Objectives\Requests\StoreObjectiveRequest;
use TrainingTracker\Http\Objectives\Requests\UpdateObjectiveRequest;

class ObjectivesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('objectives.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lessons = $this->sortedLessons();

        return view('objectives.create', compact('lessons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreObjectiveRequest $request)
    {
        Objective::create([
            'lesson_id' => request('lesson_id'),
            'number' => request('number'),
            'name' => [
                'en' => request('name_en'),
                'fr' => request('name_fr')
            ],
            'notebook_required' => (int) request('notebook_required')
        ]);

        return redirect()
            ->route('objectives.index')
            ->with([
                'flash' => [
                    'message' => trans('app.flash.objectiveadded')
                ]
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \TrainingTracker\Objective  $objective
     * @return \Illuminate\Http\Response
     */
    public function edit(Objective $objective)
    {
        $lessons = $this->sortedLessons();

        return view('objectives.edit', compact('lessons', 'objective'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \TrainingTracker\Objective  $objective
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateObjectiveRequest $request, Objective $objective)
    {
        $objective->update([
            'lesson_id' => request('lesson_id'),
            'number' => request('number'),
            'name' => [
                'en' => request('name_en'),
                'fr' => request('name_fr')
            ],
            'notebook_required' => (int) request('notebook_required')
        ]);

        return redirect()
            ->route('objectives.index')
            ->with([
                'flash' => [
                    'message' => trans('app.flash.objectiveupdated')
                ]
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \TrainingTracker\Objective  $objective
     * @return \Illuminate\Http\Response
     */
    public function destroy(Objective $objective)
    {
        $objective->delete();

        return redirect()
            ->route('objectives.index')
            ->with([
                'flash' => [
                    'message' => trans('app.flash.objectivedeleted')
                ]
            ]);
    }

    protected function sortedLessons()
    {
        return Lesson::all()->load('level')->sort(function($a, $b) {
            if($a->level->name === $b->level->name) {
                if($a->number === $b->number) {
                    return 0;
                }

                return $a->number < $b->number ? -1 : 1;
            } 
            
            return $a->level->name < $b->level->name ? -1 : 1;
        });
    }
}

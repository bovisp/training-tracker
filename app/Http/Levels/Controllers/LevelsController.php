<?php

namespace TrainingTracker\Http\Levels\Controllers;

use Illuminate\Http\Request;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Levels\Level;
use TrainingTracker\Http\Levels\Requests\StoreLevelRequest;
use TrainingTracker\Http\Levels\Requests\UpdateLevelRequest;

class LevelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('levels.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('levels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLevelRequest $request)
    {
        Level::create([
            'name' => [
                'en' => request('name_en'),
                'fr' => request('name_fr')
            ]
        ]);

        return redirect()
            ->route('levels.index')
            ->with([
                'flash' => [
                    'message' => 'Level successfully added.'
                ]
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \TrainingTracker\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit(Level $level)
    {
        return view('levels.edit', compact('level'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \TrainingTracker\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLevelRequest $request, Level $level)
    {
        $level->update([
            'name' => [
                'en' => request('name_en'),
                'fr' => request('name_fr')
            ]
        ]);

        return redirect()
            ->route('levels.index')
            ->with([
                'flash' => [
                    'message' => 'Level successfully updated.'
                ]
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \TrainingTracker\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Level $level)
    {
        $level->delete();

        return redirect()
            ->route('levels.index')
            ->with([
                'flash' => [
                    'message' => 'Level successfully deleted.'
                ]
            ]);
    }
}

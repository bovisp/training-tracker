<?php

namespace TrainingTracker\Http\Topics\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Topics\Topic;
use TrainingTracker\Http\Topics\Resources\TopicResource;

class TopicsController extends Controller
{
    public function index()
    {
        return [
            'records' => TopicResource::collection(Topic::all()),
            'meta' => [
                'displayable' => [
                    ['key' => 'number', 'title' => 'Number'],
                    ['key' => 'name', 'title' => 'Name']
                ],
                'orderby' => [
                    ['key' => 'number', 'dir' => 'asc']
                ],
                'actionButton' => [
                    'active' => true,
                    'endpoint' => '/topics/',
                    'endpointSuffix' => '/edit',
                    'text' => 'Edit'
                ]
            ]
        ];
    }
}

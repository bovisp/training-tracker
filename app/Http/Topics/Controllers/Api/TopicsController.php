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
                    ['field' => 'number', 'label' => 'Number', 'sortable' => 'sortable'],
                    ['field' => 'name', 'label' => 'Name', 'sortable' => 'sortable']
                ],
                'orderby' => [
                    ['key' => 'number', 'dir' => 'asc']
                ],
                'actionButton' => [
                    'active' => true,
                    'endpoint' => env('APP_URL') . '/topics/',
                    'endpointSuffix' => '/edit',
                    'text' => 'Edit'
                ]
            ]
        ];
    }
}

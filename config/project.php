<?php

return [

    'name'     => 'GitHub Project Analyzer',
    'criteria' => [
        'subscribers' => [
            'weight'  => env('GITHUB_SUBSCRIBERS',10),
            'lim1'    => env('GITHUB_SUBSCRIBERS_LIM1',5),
            'lim2'    => env('GITHUB_SUBSCRIBERS_LIM2',10),
            'lim3'    => env('GITHUB_SUBSCRIBERS_LIM3',25),
            'lim4'    => env('GITHUB_SUBSCRIBERS_LIM4',50),
            'lim5'    => env('GITHUB_SUBSCRIBERS_LIM5',100)
        ],
        'star'        => [
            'weight'  => env('GITHUB_STAR',20),
            'lim1'    => env('GITHUB_STAR_LIM1',5),
            'lim2'    => env('GITHUB_STAR_LIM2',10),
            'lim3'    => env('GITHUB_STAR_LIM3',25),
            'lim4'    => env('GITHUB_STAR_LIM4',50),
            'lim5'    => env('GITHUB_STAR_LIM5',100)
        ],
        'fork'        => [
            'weight'  => env('GITHUB_FORK',20),
            'lim1'    => env('GITHUB_FORK_LIM1',5),
            'lim2'    => env('GITHUB_FORK_LIM2',10),
            'lim3'    => env('GITHUB_FORK_LIM3',25),
            'lim4'    => env('GITHUB_FORK_LIM4',50),
            'lim5'    => env('GITHUB_FORK_LIM5',100)
        ],
        'commit'      => [
            'weight'  => env('GITHUB_COMMIT',10),
            'lim1'    => env('GITHUB_COMMIT_LIM1',10),
            'lim2'    => env('GITHUB_COMMIT_LIM2',25),
            'lim3'    => env('GITHUB_COMMIT_LIM3',50),
            'lim4'    => env('GITHUB_COMMIT_LIM4',100),
            'lim5'    => env('GITHUB_COMMIT_LIM5',250)
        ],
        'contributor' => [
            'weight'  => env('GITHUB_CONTRIBUTOR',25),
            'lim1'    => env('GITHUB_CONTRIBUTOR_LIM1',5),
            'lim2'    => env('GITHUB_CONTRIBUTOR_LIM2',10),
            'lim3'    => env('GITHUB_CONTRIBUTOR_LIM3',15),
            'lim4'    => env('GITHUB_CONTRIBUTOR_LIM4',20),
            'lim5'    => env('GITHUB_CONTRIBUTOR_LIM5',25)
        ],
        'update'      => env('GITHUB_UPDATE',15),
    ],
    'update'  => [
        'deadline'    => env('GITHUB_UPDATE_DEADLINE',180),
        'unit'        => env('GITHUB_UPDATE_UNIT','DAY')
    ]

];

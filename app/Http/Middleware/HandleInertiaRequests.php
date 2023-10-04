<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
       
        return array_merge(parent::share($request), [
           

            'is_admin' =>  $request->user() ? !$request->user()->hasRole('user') : true,
            'genres' => \App\Models\Genre::all('id', 'slug','title'),
            'auth'=>[
                'user'=>$request->user(),
                'can'=>$request->user()?$request->user()->getPermissionArray():[],
            ],
            // 'can' => [
            //     'show_movies'=> auth()->user()?->can('show movies') ,
            //     'show_tvShows'=> auth()->user()?->can('show tvShows') ,
            //     'show_genres'=> auth()->user()?->can('show genres') ,
            //     'show_cast'=> auth()->user()?->can('show cast') ,
            //     'show_tags'=> auth()->user()?->can('show tags') ,
            //     'show_users'=> auth()->user()?->can('show users') ,
            //     'show_roles'=> auth()->user()?->can('show roles') ,
            //     'show_permissions'=> auth()->user()?->can('show permissions') ,

            // ],
        ]);
    }
}

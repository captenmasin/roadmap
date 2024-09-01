<div class="hidden lg:block">
    <aside class="w-60" aria-label="Sidebar">
        <div class="overflow-y-auto space-y-4">
            <ul class="space-y-2">
                <li>
                    <a
                        @class([
                                'flex items-center h-10 px-2 space-x-2 transition rounded-lg ',
                                'text-white bg-brand-500' => request()->is('/'),
                                'hover:bg-gray-500/5 focus:bg-brand-500/10 focus:text-brand-600 focus:outline-none' => !request()->is('/')
                            ])
                        href="{{ route('home') }}">

                        <x-heroicon-o-home class="w-5 h-5 {{ !request()->is('/') ? 'text-gray-500' : ''  }}"/>

                        <span
                            class="font-normal {{ !request()->is('/') ? 'text-gray-900' : ''  }}">{{ trans('general.dashboard') }}</span>
                    </a>
                </li>

                <li>
                    <a
                        @class([
                            'flex items-center h-10 px-2 space-x-2 transition rounded-lg ',
                            'text-white bg-brand-500' => request()->is('my'),
                            'hover:bg-gray-500/5 focus:bg-brand-500/10 focus:text-brand-600 focus:outline-none' => !request()->is('my')
                        ])
                        href="{{ route('my') }}">
                        <x-heroicon-o-queue-list class="w-5 h-5 {{ !request()->is('my') ? 'text-gray-500' : ''  }}"/>

                        <span class="font-medium">{{ trans('items.my-items') }}</span>
                    </a>
                </li>

                @if(app(App\Settings\GeneralSettings::class)->enable_changelog)
                    <li>
                        <a
                            @class([
                                'flex items-center h-10 px-2 space-x-2 transition rounded-lg ',
                                'text-white bg-brand-500' => request()->is('changelog*'),
                                'hover:bg-gray-500/5 focus:bg-brand-500/10 focus:text-brand-600 focus:outline-none' => !request()->is('changelog*')
                            ])
                            href="{{ route('changelog') }}">
                            <x-heroicon-o-rss
                                class="w-5 h-5 {{ !request()->is('changelog*') ? 'text-gray-500' : ''  }}"/>

                            <span class="font-medium">{{ trans('changelog.changelog') }}</span>
                        </a>
                    </li>
                @endif

                <li class="pt-2">
                    <a
                        @class([
                            'flex items-center h-10 px-2 space-x-2 transition rounded-lg ',
                            'hover:bg-gray-500/5 focus:bg-brand-500/10 focus:text-brand-600 focus:outline-none'
                        ])
                        target="_blank"
                        href="https://novogamer.com">


                        <svg class="w-5" viewBox="0 0 150 135" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M36.0396 77.6799L72.8093 98.689L10.2992 133.504C5.68205 136.075 0 132.736 0 127.449V45.1013C0 40.4917 2.49493 36.2397 6.52637 33.9958L34.5487 18.3949C38.4356 16.227 43.1668 16.2575 47.0309 18.4633L77.1907 35.692L36.1536 58.5419C28.6917 62.6951 28.6308 73.4202 36.0548 77.6647L36.0396 77.6799Z" fill="#C27DFF"/>
                            <path d="M113.861 75.8392L72.8169 98.6891L36.0471 77.68C28.6232 73.4356 28.684 62.7104 36.146 58.5573L77.183 35.7074L113.96 56.7241C121.384 60.961 121.323 71.6861 113.861 75.8392Z" fill="#121D38"/>
                            <path d="M150 6.9472V89.3027C150 93.9122 147.505 98.1566 143.474 100.393L115.444 115.994C111.564 118.162 106.833 118.131 102.977 115.933L72.8093 98.6891L113.854 75.8392C121.316 71.686 121.377 60.9609 113.953 56.7241L77.1755 35.7073L139.701 0.884824C144.318 -1.68617 150 1.65308 150 6.93959V6.9472Z" fill="#6E51FC"/>
                        </svg>


                        <span class="font-medium">Novogamer</span>
                    </a>
                </li>
            </ul>
            <div>
                <p class="px-2 text-lg font-semibold mb-2">{{ trans('projects.projects') }}</p>
                @if($projects->count() > 0)
                    <ul class="space-y-2">
                        @foreach($projects->groupBy('group') as $group => $projects)
                            @if($group)
                                <li class="mb-3">
                                    <div
                                        class="flex items-center h-2 px-2 space-x-2 transition rounded-lg mt-5"
                                    >
                                        <span class="font-normal text-gray-500 truncate">{{ $group }}</span>

                                    </div>
                                </li>
                            @endif

                            @foreach($projects as $project)
                                <li>
                                    <a
                                        title="{{ $project->title }}"
                                        @class([
                                       'flex items-center h-10 px-2 space-x-2 transition rounded-lg ',
                                       'text-white bg-brand-500' => request()->segment(2) === $project->slug,
                                       'hover:bg-gray-500/5 focus:bg-brand-500/10 focus:text-brand-600 focus:outline-none' => request()->segment(2) !== $project->slug
                                   ])
                                        href="{{ route('projects.show', $project) }}">
                                        <x-dynamic-component :component="$project->icon ?? 'heroicon-o-hashtag'"
                                                             class="flex-shrink-0 w-5 h-5 {{ request()->segment(2) == $project->slug ? '' : 'text-gray-500'  }}"/>

                                        <span class="font-normal truncate">{{ $project->title }}</span>

                                        @if($project->private)
                                            <div class="flex-1 flex justify-end">
                                                <x-heroicon-s-lock-closed
                                                    class="w-4 h-4 {{ request()->segment(2) == $project->slug ? '' : 'text-primary'  }}"/>
                                            </div>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        @endforeach
                    </ul>
                @else
                    <div class="px-2">
                        <span class="text-sm text-gray-500">{{ trans('projects.no-projects') }}</span>
                    </div>
                @endif
            </div>

            <div id="dropdown-cta" class="p-4 mt-6 bg-gray-100 rounded-lg" role="alert">
                <p class="text-sm text-gray-500">
                    <a href="https://github.com/ploi/roadmap" target="_blank"
                       class="font-semibold border-b border-dotted">Open-source</a>
                    roadmapping software by
                    <a href="https://ploi.io/?ref=roadmap" target="_blank" class="font-semibold border-b border-dotted">ploi.io</a>
                </p>

                <p class="text-[0.6rem] text-gray-400">
                    Running version {{ (new \App\Services\SystemChecker())->getApplicationVersion() }}
                </p>
            </div>
        </div>
    </aside>
</div>

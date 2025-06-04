<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col space-y-2">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-2">
        @if(count($tasks) != 0 && !is_null($tasks))
        <div class="flex flex-col space-y-2">
            <span class="text-lg font-semibold">Прошедшие и ближайшие события</span>
            <div class="flex flex-row flex-wrap space-x-0 space-y-2 md:space-x-2 md:space-y-0">
                @foreach($tasks as $value)
                <div class="w-full md:w-[23rem;] flex flex-col hover:bg-slate-200 border border-slate-400/20 rounded px-4 py-2 cursor-pointer">
                    <div class="text-lg font-semibold">
                        {{ $value->title }}
                    </div>
                    <div class="h-32 flex flex-col">
                        <span>Категория:</span>
                        <span>{{ $value->name }}</span>
                    </div>
                    <div class="text-sm inline-flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                            <path d="M12 7v5l3 3" />
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($value->due_date)->format('d.m.Y') }} {{ $value->time }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="mt-2">
            {{ $tasks->links() }}
        </div>
        @else
        <div class="flex flex-col space-y-2 bg-sky-400 rounded px-4 py-4 text-xs sm:text-sm md:text-sm lg:text-base xl:text-base text-justify font-medium" role="alert">
            <div class="inline-flex items-baseline space-x-2">
                <span class="text-white font-semibold">Информация</span>
            </div>
            <span class="text-white">Информация отсутсвует. Для добавления новой задачи перейдите на вкладку <a href="{{ route('tasks') }}" class="underline font-bold">"Задачи"</a></span>
        </div>
        @endif
    </div>
</div>
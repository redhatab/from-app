<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col space-y-2">

    <div class="w-full flex justify-end">
        <button wire:click="getRecommendations()" class="bg-green-400 hover:bg-green-500 rounded px-2 py-1 text-white">Получить рекомендацию от ИИ</button>
    </div>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-2">
        @if(!is_null($responseToChat))
        <span class="text-justify">{{ $responseToChat }}</span>
        @else
        <div class="flex flex-col space-y-2 bg-sky-400 rounded px-4 py-4 text-xs sm:text-sm md:text-sm lg:text-base xl:text-base text-justify font-medium" role="alert">
            <div class="inline-flex items-baseline space-x-2">
                <span class="text-white font-semibold">Информация</span>
            </div>
            <span class="text-white">Информация отсутсвует. Для получения рекомендаций от ИИ по оптимизации задач нажмите на кнопку "Получить рекомендацию от ИИ"</span>
        </div>
        @endif
    </div>

    <div wire:loading wire:target="getRecommendations" class="fixed inset-0 transform transition-all">
        <div class="absolute inset-0 bg-gray-500 opacity-75 flex flex-col items-center justify-center">
            <h1 class="text-white text-xl font-medium">Идет обработка данных</h1>
        </div>
    </div>
</div>
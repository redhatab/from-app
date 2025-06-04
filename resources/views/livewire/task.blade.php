<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col space-y-2">

    <!-- alert -->
    @if(session()->has('msg'))
    <div class="flex flex-col space-y-2 bg-green-400 rounded px-4 py-4 text-xs sm:text-sm md:text-sm lg:text-base xl:text-base text-justify font-medium" role="alert">
        <div class="inline-flex items-baseline space-x-2">
            <span class="text-white font-semibold">Сообщение</span>
        </div>
        <span class="text-white">{{ session('msg')  }}</span>
    </div>
    @endif

    <div class="w-full flex justify-end">
        <button wire:click="setEntryModalVisible(false)" class="bg-green-400 hover:bg-green-500 rounded px-2 py-1 text-white">Добавить новую задачу</button>
    </div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-2">
        @if(count($tasks) != 0 && !is_null($tasks))
        <!-- Desktop -->
        <div class="hidden lg:block">
            <table class="w-full text-xs lg:text-sm">
                <thead class="bg-slate-200">
                    <tr class="border-b border-slate-400/20">
                        <th scope="col" class="w-12 px-2 py-2 text-center font-semibold">№ пп</th>
                        <th scope="col" class="w-64 px-2 py-2 text-left font-semibold">Наименование задачи</th>
                        <th scope="col" class="w-auto px-2 py-2 text-left font-semibold">Комментарий</th>
                        <th scope="col" class="w-32 px-2 py-2 font-semibold">Дата и время исполнения</th>
                        <th scope="col" class="w-40 px-2 py-2 text-left font-semibold">Категория</th>
                        <th scope="col" class="w-24 px-2 py-2 font-semibold">Статус</th>
                        <th scope="col" class="w-32 px-2 py-2 font-semibold">Действия</th>
                    </tr>
                </thead>

                <body>
                    @foreach($tasks as $value)
                    <tr class="bg-white hover:bg-slate-200 border-b border-slate-400/20">
                        <td class="w-12 px-2 py-2 text-center">{{ $loop->iteration }}</td>
                        <td class="w-64 px-2 py-2 text-left">{{ $value->title }}</td>
                        <td class="w-auto px-2 py-2 text-left">{{ $value->description }}</td>
                        <td class="w-32 px-2 py-2">{{ \Carbon\Carbon::parse($value->due_date)->format('d.m.Y') }} {{ $value->time }}</td>
                        <td class="w-40 px-2 py-2">{{ $value->name }}</td>
                        <td class="w-24 px-2 py-2 text-center">
                            @if($value->completed)
                            <span class="text-green-500 cursor-pointer">Выполнено</span>
                            @else
                            <span class="text-orange-500 cursor-pointer">В работе</span>
                            @endif
                        </td>
                        <td class="w-32 px-2 py-2 text-center">
                            <button wire:click="setEntryModalVisible(true, {{ $value->id }})" class="bg-orange-400 hover:bg-orange-500 rounded px-2 py-1 text-xs text-center text-white" title="Редактировать">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                    <path d="M16 5l3 3" />
                                </svg>
                            </button>
                            <button onclick="confirmDestroy('{{ $value->id }}')" class="bg-red-400 hover:bg-red-500 rounded px-2 py-1 text-xs text-center text-white" title="Удалить">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 7l16 0" />
                                    <path d="M10 11l0 6" />
                                    <path d="M14 11l0 6" />
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </body>
            </table>
        </div>
        <!-- Mobile -->
        <div class="lg:hidden flex flex-col space-y-2">
            @foreach($tasks as $value)
            <div class="flex flex-col space-y-2 bg-slate-200 dark:bg-slate-700 border rounded border-slate-200 dark:border-slate-400/20 p-4 text-xs">
                <div class="flex flex-col">
                    <span class="font-semibold">Наименование задачи:</span>
                    <span>{{ $value->title }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-semibold">Комментарий:</span>
                    <span>{{ $value->description }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-semibold">Дата и время исполнения:</span>
                    <span>{{ \Carbon\Carbon::parse($value->due_date)->format('d.m.Y') }} {{ $value->time }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-semibold">Категория:</span>
                    <span>{{ $value->name }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-semibold">Статус:</span>
                    @if($value->completed)
                    <span class="text-green-500 cursor-pointer">Выполнено</span>
                    @else
                    <span class="text-orange-500 cursor-pointer">В работе</span>
                    @endif
                </div>
                <div class="flex flex-col">
                    <span class="font-semibold">Действия:</span>
                    <div class="flex flex-row space-x-2">
                        <button wire:click="setEntryModalVisible(true, {{ $value->id }})" class="w-auto grow bg-orange-400 hover:bg-orange-500 rounded px-2 py-1 text-xs text-center text-white font-bold" title="Редактировать">
                            Редактировать
                        </button>
                        <button onclick="confirmDestroy('{{ $value->id }}')" class="w-auto grow bg-red-400 hover:bg-red-500 rounded px-2 py-1 text-xs text-center text-white font-bold" title="Удалить">
                            Удалить
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-2">
            {{ $tasks->links() }}
        </div>
        @else
        <div class="flex flex-col space-y-2 bg-sky-400 rounded px-4 py-4 text-xs sm:text-sm md:text-sm lg:text-base xl:text-base text-justify font-medium" role="alert">
            <div class="inline-flex items-baseline space-x-2">
                <span class="text-white font-semibold">Информация</span>
            </div>
            <span class="text-white">Информация отсутсвует. Для добавления новой задачи нажмите на кнопку "Добавить новую задачу"</span>
        </div>
        @endif
    </div>

    <!-- Entry Modal -->
    <x-dialog-modal wire:model="isEntryModalVisible">
        <form>
            @csrf
            <x-slot name="title">
                {{ (!$isEdit) ? __('Добавление записи') : __('Редактирования записи') }}
            </x-slot>

            <x-slot name="content">
                <div class="flex flex-col space-y-2">
                    <div class="flex flex-col">
                        <label for="category-id" class="font-semibold">Категория<span class="ml-1 text-red-400">*</span></label>
                        <select wire:model="category_id" name="category_id" id="category-id" class="w-full border border-gray-300 rounded text-sm md:text-base focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <option value="0">Выберите категорию</option>
                            @foreach($categories as $key => $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-400 font-semibold">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="title" class="font-semibold">Задача<span class="ml-1 text-red-500">*</span></label>
                        <textarea wire:model="title" name="title" id="title" cols="5" rows="2" class="w-full border border-gray-300 rounded px-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"></textarea>
                        @error('title') <span class="text-red-400 font-semibold">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="description" class="font-semibold">Комментарий</label>
                        <textarea wire:model="description" name="description" id="description" cols="5" rows="5" class="w-full border border-gray-300 rounded px-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"></textarea>
                    </div>
                    <div class="w-full flex flex-col">
                        <label for="due-date" class="font-semibold">Срок исполнения<span class="ml-1 text-red-500">*</span></label>
                        <input wire:model="due_date" type="text" id="due-date" class="w-full border border-gray-300 rounded px-2 text-sm md:text-base focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500" tabindex="-1">
                        @error('due_date') <span class="text-red-400 font-semibold">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="time" class="font-semibold">Время<span class="ml-1 text-red-500">*</span></label>
                        <input type="text" wire:model="time" name="time" id="time" placeholder="h:m" class="w-full border border-gray-300 rounded px-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        @error('time') <span class="text-red-400 font-semibold">{{ $message }}</span> @enderror
                    </div>
                    <div class="inline-flex py-2">
                        <label for="completed">
                            <input wire:model="completed" type="checkbox" name="completed" id="completed" class="mr-1">Выполнено
                        </label>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <button wire:click="$toggle('isEntryModalVisible')" type="button" class="w-full sm:w-auto bg-gray-400 hover:bg-gray-500 rounded px-2 py-2 text-xs text-white font-bold">
                    {{ __('Отменить') }}
                </button>
                <button wire:click="{{ (!$isEdit) ? 'store()' : 'update()' }}" type="button" class="ml-2 w-full sm:w-auto bg-blue-400 hover:bg-blue-500 rounded px-2 py-2 text-xs text-white font-bold">
                    {{ (!$isEdit) ? __('Добавить') : __('Обновить') }}
                </button>
            </x-slot>
        </form>
    </x-dialog-modal>
</div>

@push('scripts')
<script>
    var pickerLessonDate = new Pikaday({
        field: document.getElementById('due-date'),
        format: 'DD.MM.YYYY',
        onSelect: function() {
            @this.set('due_date', document.getElementById('due-date').value);
        }
    });

    function confirmDestroy(id) {
        if (confirm('Вы уверены, что хотите удалить данную запись?')) {
            @this.destroy(id);
        }
    }
</script>
@endpush
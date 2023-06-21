<x-filament::page>
    <div class="text-xl">
        {{ \Carbon\Carbon::now()->format('d-m-Y') }}
    </div>
    <div>
        <div class="w-full overflow-hidden rounded-lg shadow-lg border-t mb-4">
            <div class="w-full overflow-x-auto mt-4">

                <table class="w-full whitespace-no-wrap">
                    <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Талон</th>
                        <th class="px-4 py-3">{{ __('Subject') }}</th>
                        <th class="px-4 py-3">{{ __('Date') }}</th>
                    </tr>
                    </thead>
                    <tbody
                        class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                    >
                    @foreach($this->tickets as $item)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 text-sm">
                                {{$loop->index+1}}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{$item['number']}}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{$item->service->name}}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {{$item['updated_at']}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="p-2">
                    {{ $this->tickets->links() }}
                </div>
            </div>
        </div>
    </div>


</x-filament::page>

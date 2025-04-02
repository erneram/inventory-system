@props([
    'noDataText' => 'No hay datos encontrados',
    'rows' => [],
    'columns' => [],
    'isStriped' => true,
    'actionText' => 'Action',
    'tableTextLinkLabel' => 'Link',
])

<div x-data="{
    columns: {{ collect($columns) }},
    rows: {{ collect($rows) }},
    isStriped: {{ collect($isStriped) }},
    currentPage: 1,
    rowsPerPage: 10,
    get paginatedRows() {
        const start = (this.currentPage - 1) * this.rowsPerPage;
        const end = this.currentPage * this.rowsPerPage;
        return this.rows.slice(start, end);
    },
    get totalPages() {
        return Math.ceil(this.rows.length / this.rowsPerPage);
    },
    goToPage(page) {
        if (page >= 1 && page <= this.totalPages) {
            this.currentPage = page;
        }
    },
    changeRowsPerPage(event) {
        this.rowsPerPage = parseInt(event.target.value); // Update rows per page
        this.currentPage = 1; // Reset to the first page whenever the selection changes
    },
}" x-cloak class="overflow-x-auto">

    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
            <tr class="text-left">
                @isset($tableColumns)
                    {{ $tableColumns }}
                @else
                    @isset($tableTextLink)
                        <th
                            class="bg-gray-50 sticky top-0 border-b border-gray-100 px-6 py-3 text-gray-500 font-bold tracking-wider uppercase text-xs truncate">
                            {{ $tableTextLinkLabel }}
                        </th>
                    @endisset

                    <template x-for="column in columns">
                        <th :class="column.columnClasses"
                            class="bg-gray-50 sticky top-0 border-b border-gray-100 px-6 py-3 text-gray-500 font-bold tracking-wider uppercase text-xs truncate"
                            x-text="column.name"></th>
                    </template>

                    @isset($tableActions)
                        <th
                            class="bg-gray-50 sticky top-0 border-b border-gray-100 px-6 py-3 text-gray-500 font-bold tracking-wider uppercase text-xs truncate">
                            {{ $actionText }}
                        </th>
                    @endisset
                @endisset
            </tr>
        </thead>
        <tbody>
            <template x-if="rows.length === 0">
                @isset($empty)
                    {{ $empty }}
                @else
                    <tr>
                        <td colspan="100%" class="text-center py-10 px-4 py-1 text-sm">
                            {{ $noDataText }}
                        </td>
                    </tr>
                @endisset
            </template>
            <template x-for="(row, rowIndex) in paginatedRows" :key="'row-' + rowIndex">
                <tr :class="{ 'bg-gray-50': isStriped && ((rowIndex + 1) % 2 === 0) }">
                    {{-- Custom slots for all rows customization --}}
                    @isset($tableRows)
                        {{ $tableRows }}
                    @else
                        {{-- Custom slots to display a link text --}}
                        @isset($tableTextLink)
                            <td class="text-gray-600 px-6 py-3 border-t border-gray-100 whitespace-nowrap">
                                {{ $tableTextLink }}
                            </td>
                        @endisset
                        <template x-for="(column, columnIndex) in columns" :key="'column-' + columnIndex">
                            <td :class="`${column.rowClasses}`"
                                class="text-gray-600 px-6 py-3 border-t border-gray-100 whitespace-nowrap">
                                <div x-text="`${row[column.field] !== null ? row[column.field] : 'N/A'}`" class="truncate">
                                </div>
                            </td>
                        </template>
                        {{-- Custom slots for action links --}}
                        @isset($rowActions)
                            <td class="text-gray-600 px-6 py-3 border-t border-gray-100 whitespace-nowrap">
                                {{ $rowActions }}
                            </td>
                        @endisset
                    @endisset
                </tr>
            </template>
        </tbody>
    </table>

    <div class="flex justify-between items-center mt-4 px-4">
        <div class="flex justify-between items-center text-white">
            <span class="mr-2">Mostrar</span>
            <select x-on:change="changeRowsPerPage" x-bind:value="rowsPerPage"
                class="border border-gray-300 rounded p-2 text-md text-black w-24"> <!-- Limited width -->
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </select>
            <span class="ml-2 ">items</span>
        </div>

        <div class="flex items-center">
            <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1"
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded disabled:opacity-50">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </button>
            <div class="text-center text-white px-2">
                <span x-text="currentPage"></span> de <span x-text="totalPages"></span>
            </div>
            <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages"
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded disabled:opacity-50">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>
    </div>

</div>

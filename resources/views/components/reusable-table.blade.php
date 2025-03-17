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
        isStriped: {{collect($isStriped)}}
	}" x-cloak class="overflow-x-auto">

    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
            <tr class="text-left">
                @isset($tableColumns)
                    {{ $tableColumns }}
                @else
                    @isset($tableTextLink)
                        <th class="bg-gray-50 sticky top-0 border-b border-gray-100 px-6 py-3 text-gray-500 font-bold tracking-wider uppercase text-xs truncate">
                            {{ $tableTextLinkLabel }}
                        </th>
                    @endisset

                    <template x-for="column in columns">
                        <th
                            :class="column.columnClasses"
                            class="bg-gray-50 sticky top-0 border-b border-gray-100 px-6 py-3 text-gray-500 font-bold tracking-wider uppercase text-xs truncate"
                            x-text="column.name"></th>
                    </template>

                    @isset($tableActions)
                        <th class="bg-gray-50 sticky top-0 border-b border-gray-100 px-6 py-3 text-gray-500 font-bold tracking-wider uppercase text-xs truncate">{{ $actionText }}</th>
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
                            {{$noDataText}}
                        </td>
                    </tr>
                @endisset
            </template>
            <template x-for="(row, rowIndex) in rows" :key="'row-' +rowIndex">
                <tr :class="{'bg-gray-50    ': isStriped && ((rowIndex + 1) % 2 === 0)}">
                    {{-- Custom slots for all rows customization --}}
                    @isset($tableRows)
                    {{ $tableRows }}
                    @else
                    {{-- Custom slots to display a link text --}}
                    @isset($tableTextLink)
                        <td
                        class="text-gray-600 px-6 py-3 border-t border-gray-100 whitespace-nowrap">
                        {{ $tableTextLink }}
                        </td>
                    @endisset
                    <template x-for="(column, columnIndex) in columns" :key="'column-' + columnIndex">
                        <td
                        :class="`${column.rowClasses}`"
                        class="text-gray-600 px-6 py-3 border-t border-gray-100 whitespace-nowrap">
                        <div x-text="`${row[column.field]}`" class="truncate"></div>
                        </td>
                    </template>
                    {{-- Custom slots for action links --}}
                    @isset($rowActions)
                        <td
                        class="text-gray-600 px-6 py-3 border-t border-gray-100 whitespace-nowrap">
                        {{ $rowActions }}
                        </td>
                    @endisset
                    @endisset
                </tr>
            </template>
        </tbody>
    </table>
</div>

<div class="overflox-x-auto">
    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
            <tr>
                @foreach ($headers as $header)
                    <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">{{$header}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr class="border-b hover:bg-gray-100">
                    @foreach ($row as $cell)
                    <td class="py-3 px-5 text-sm text-gray-600">{{$cell}}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

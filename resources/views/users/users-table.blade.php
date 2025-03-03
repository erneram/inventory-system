<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl text-white font-bold mb-6">Usuarios</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success')}}
            </div>
        @endif

        {{-- TABLA PRECIOS --}}
        <div class="overflox-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Id</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Nombre</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Apellido</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Rol</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Creado en</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3 px-5 text-sm text-gray-600">{{$user->id}}</td>
                            <td class="py-3 px-5 text-sm text-gray-600">{{$user->name}}</td>
                            <td class="py-3 px-5 text-sm text-gray-600">{{$user->last_name}}</td>
                            <td class="py-3 px-5 text-sm text-gray-600">{{$user->email}}</td>
                            <td class="py-3 px-5 text-sm text-gray-600">{{$user->role}}</td>
                            <td class="py-3 px-5 text-sm text-gray-600">
                            {{$user->created_at ? $user->created_at->format('d/m/Y H:i') : ''}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

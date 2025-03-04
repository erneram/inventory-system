<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl text-white font-bold mb-6">Usuarios</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success')}}
            </div>
        @endif
        <x-reusable-table
            :headers="['ID', 'Nombre', 'Apellido', 'Email', 'Rol', 'Creado en']"
            :rows="$users->map(function($user){
                return [
                    $user->id,
                    $user->name,
                    $user->last_name,
                    $user->email,
                    $user->role,
                    $user->created_at ? $user->created_at->format('d/m/Y H:i') : ''
                ];
            })"
        />
    </div>
</x-app-layout>

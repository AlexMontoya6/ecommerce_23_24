<div>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-600">
                Lista de productos
            </h2>
            <x-button-link class="ml-auto" href="{{ route('admin.products.create') }}">
                Agregar producto
            </x-button-link>
        </div>
    </x-slot>

    <div class="container-menu py-12">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <x-table-responsive>
                            <div class="px-6 py-4">
                                <x-jet-input class="w-full" wire:model="search" type="text"
                                    placeholder="Introduzca el nombre del producto a buscar" />
                            </div>
                            <div class="px-6 py-4 flex justify-end">
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" class="bg-gray-200 p-2 rounded">Configurar
                                        Columnas</button>
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute right-0 w-40 bg-white shadow-xl z-10">
                                        <div class="p-2">
                                            @foreach (['name' => 'Nombre', 'category' => 'Categoría', 'status' => 'Estado', 'price' => 'Precio'] as $col => $label)
                                                <label class="block"><input type="checkbox" wire:model="visibleColumns"
                                                        value="{{ $col }}"> {{ $label }}</label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>




                            @if ($products->count())
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            @if(in_array('name', $visibleColumns))
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nombre
                                            </th>
                                            @endif
                                            @if(in_array('category', $visibleColumns))
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Categoría
                                            </th>
                                            @endif
                                            @if(in_array('status', $visibleColumns))
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Estado
                                            </th>
                                            @endif
                                            @if(in_array('price', $visibleColumns))
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Precio
                                            </th>
                                            @endif
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Editar</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($products as $product)
                                            <tr>
                                                @if(in_array('name', $visibleColumns))
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10 object-cover">
                                                            <img class="h-10 w-10 rounded-full"
                                                                src="{{ $product->images->count() ? Storage::url($product->images->first()->url) : 'img/default.jpg' }}"
                                                                alt="">
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $product->name }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                @endif
                                                @if(in_array('category', $visibleColumns))
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">
                                                        {{ $product->subcategory->category->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $product->subcategory->name }}
                                                    </div>
                                                </td>
                                                @endif
                                                @if(in_array('status', $visibleColumns))
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $product->status == 1 ? 'red' : 'green' }}-100 text-{{ $product->status == 1 ? 'red' : 'green' }}-800">
                                                        {{ $product->status == 1 ? 'Borrador' : 'Publicado' }}
                                                    </span>
                                                </td>
                                                @endif
                                                @if(in_array('price', $visibleColumns))
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $product->price }} &euro;
                                                </td>
                                                @endif
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{ route('admin.products.edit', $product) }}"
                                                        class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="px-6 py-4">
                                    No existen productos coincidentes
                                </div>
                            @endif
                            @if ($products->hasPages())
                                <div class="px-6 py-4">
                                    {{ $products->links() }}
                                </div>
                            @endif
                        </x-table-responsive>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

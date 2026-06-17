<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Úložisko a doménové meno
        </h2>
    </x-slot>


    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div style="color: red;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div style="color: green;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (auth()->user()->plan_id)
                       
                        <form method="POST" action="{{ route('webspace.store') }}">
                        @csrf
                        <div>
                            <label>Doménové meno</label>
                            <input type="text" name="domain" placeholder="example.test" required>
                        </div>
                        <br>
                        <div>
                            <label>Typ webovej stránky</label>
                            <select name="type" id="">
                                <option value="classic">Klasická stránka</option>
                                <option value="laravelapp">Laravel aplikácia</option>
                            </select>
                        </div>

                        <br>

                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Vytvoriť</button>
                        </form>
                        
                    @endif

                    <br><br>
                    @if ( $webspace->isEmpty() )
                        <p>Nemáte zadané žiadne doménové meno</p>
                    @else
                        @foreach ( $webspace as $wb )
                            {{ $wb->domain }}
                        @endforeach
                    @endif

                    

                </div>
            </div>
        </div>
    </div>

</x-app-layout>

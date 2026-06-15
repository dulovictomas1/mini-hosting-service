<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Databázy
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
                       
                        <form action="{{ route('databases.store') }}" method="post" class="mt-6 space-y-6">
                            @csrf
                            <label for="">Názov databázy (nesmie obsahovať diakritiku ani špeciálne znaky):</label>
                            <input type="text" name="database_name" id="">

                            <br><br>

                            <label for="">Vyberte charset pre databázu:</label>
                            <select name="charset" required>
                                @foreach ($charsets as $charset)
                                    <option value="{{ $charset }}">
                                        {{ $charset }}
                                    </option>
                                @endforeach
                            </select>

                            <br><br>

                            <label for="">Vyberte collation pre databázu:</label>
                            <select name="collation" required>
                                @foreach ($collations as $collation)
                                    <option value="{{ $collation }}">
                                        {{ $collation }}
                                    </option>
                                @endforeach
                            </select>

                            <br><br>

                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Vytvoriť databázu</button>
                        </form>
                        
                    @endif

                    <br><br>
                    @if ( $databases->isEmpty() )
                        <p>Nemáte vytvorenú žiadnu databázu</p>
                    @else
                        @foreach ( $databases as $db )
                        <p>Prístupové údaje:</p>
                            Prihlasovacie meno: <b>{{ $db->database_name }}</b><br>
                            Názov databázy: <b>{{ $db->database_user }}</b>
                        @endforeach
                    @endif

                    <br><br>

                    @if (session('databasePassword'))
                        <div>
                            <p>
                                Heslo databázy:
                                <strong>{{ session('databasePassword') }}</strong>
                            </p>
                            <p>
                                Toto heslo sa zobrazí iba raz.
                            </p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!--{{ __("You're logged in!") }} -->
                    Vitajte {{ Auth::user()->name }}
                </div>
            </div>
        </div>
    </div>

    <br>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (! auth()->user()->plan_id)
                        
                        <h3>Vyberte si hostingový balíček</h3>
                                            
                        @foreach ($plans as $plan)
                            <div class="plan">
                                <p>Balíček: {{ $plan->name }}</p>
                                <p>Databázový limit: {{ $plan->database_limit }}</p>

                                <form action="{{ route('user.plan.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                    <button type="submit" class="btn_plan">Tento balíček chcem</button>
                                </form>
                            </div>    
                        @endforeach
                        
                    @else
                        <h3>Váš aktuálny plán:</h3>
                        <p>Názov balíčka: {{ auth()->user()->plan->name }}</p>
                        <p>Počet databáz: {{ auth()->user()->databases->count() }}/{{ auth()->user()->plan->database_limit }}</p>                        
                        <br>
                        <a href="{{ route('databazy') }}" class="btn_db">Prejsť na databázy</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

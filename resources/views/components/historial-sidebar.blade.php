@php
    $history = \Illuminate\Support\Facades\Cache::get('food_history', []);
    $recent = array_slice($history, 0, 3);
@endphp

<div class="bg-white rounded-2xl shadow-sm p-6 sticky top-24">
    <h6 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Historial Reciente</h6>
    @if(count($recent) > 0)
        <div class="space-y-4">
            @foreach($recent as $index => $item)
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" style="background: {{ ['bg-green-100', 'bg-blue-100', 'bg-purple-100'][$index % 3] }}">
                        <span class="text-xs font-bold" style="color: {{ ['text-green-700', 'text-blue-700', 'text-purple-700'][$index % 3] }}">
                            {{ ['Hoy', 'Ayer', date('d M', strtotime('-'.($index+2).' days'))][$index] }}
                        </span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800 text-sm">{{ $item['nombre'] ?? 'Plato' }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $item['nutricion']['calorias'] ?? 'N/D' }} · 
                            {{ $item['nutricion']['proteinas'] ?? '0' }}g proteína
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4 pt-4 border-t border-gray-100">
            <a href="{{ route('history') }}" class="text-sm text-primary-dark hover:text-gray-700 font-medium transition">
                Ver todo el historial <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    @else
        <p class="text-sm text-gray-400 text-center py-4">Sin análisis recientes</p>
    @endif
</div>
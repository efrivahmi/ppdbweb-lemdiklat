<div class="min-h-screen p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-slate-800 to-slate-500">
            Feedback Reviews
        </h1>
        <p class="mt-1 text-sm font-medium text-slate-500">Lihat penilaian dan masukkan dari pendaftar.</p>
    </div>

    <div class="overflow-hidden bg-white border border-gray-100 shadow-sm rounded-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold">Tanggal</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Pendaftar</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-center">Rating</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Pesan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($feedbacks as $feedback)
                    <tr class="transition-colors hover:bg-slate-50/50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-medium text-slate-700">{{ $feedback->created_at->format('d M Y') }}</span><br>
                            <span class="text-xs text-slate-400">{{ $feedback->created_at->format('H:i') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-10 h-10 font-bold text-indigo-600 rounded-full bg-indigo-50">
                                    {{ substr($feedback->user->name ?? '?', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $feedback->user->name ?? 'User Dihapus' }}</p>
                                    <p class="text-xs text-slate-500">{{ $feedback->user->email ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            @php
                                $emojiMap = [
                                    1 => ['icon' => 'ri-emotion-sad-fill', 'color' => 'text-rose-500'],
                                    2 => ['icon' => 'ri-emotion-unhappy-fill', 'color' => 'text-orange-500'],
                                    3 => ['icon' => 'ri-emotion-normal-fill', 'color' => 'text-amber-500'],
                                    4 => ['icon' => 'ri-emotion-happy-fill', 'color' => 'text-lime-500'],
                                    5 => ['icon' => 'ri-emotion-laugh-fill', 'color' => 'text-emerald-500'],
                                ];
                                $emoji = $emojiMap[$feedback->rating] ?? ['icon' => 'ri-question-fill', 'color' => 'text-slate-400'];
                            @endphp
                            <div class="flex flex-col items-center gap-1">
                                <i class="text-3xl {{ $emoji['icon'] }} {{ $emoji['color'] }}"></i>
                                <span class="text-xs font-bold {{ $emoji['color'] }}">{{ $feedback->rating }}/5</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($feedback->message)
                                <p class="text-sm text-slate-600 line-clamp-2 hover:line-clamp-none transition-all cursor-default">
                                    "{{ $feedback->message }}"
                                </p>
                            @else
                                <span class="text-xs italic text-slate-400">Tidak ada pesan</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="text-5xl text-slate-300 ri-inbox-line mb-3"></i>
                                <p class="text-sm font-medium text-slate-500">Belum ada feedback yang masuk.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($feedbacks->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-slate-50/50">
            {{ $feedbacks->links() }}
        </div>
        @endif
    </div>
</div>

@php
    $stats = \App\Models\Stat::where('player_id', $player->id)->where('for', 'player')->where('type', 'game')->with('game')->get();
@endphp

@if ($stats && $stats->count() > 0)
    <canvas id="globalChartContainer">
        ...
    </canvas>
    <script>
        window.globalChartData = {
            labels: [],
            datasets: [{
                label: 'Poeni',
                data: [],
                borderWidth: 1,
            }]
        };

        <?php foreach ($stats as $stat) : ?>
        window.globalChartData.labels.push("<?php echo Str::limit($stat?->game?->title, 40); ?>");
        window.globalChartData.datasets[0].data.push("<?php echo $stat?->score; ?>");

        <?php endforeach; ?>
    </script>
@else
    <div class="p-4 text-yellow-700 bg-yellow-100 border-l-4 border-yellow-500">
        Trenutno nema podataka.
    </div>
@endif

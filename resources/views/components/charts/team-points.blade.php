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

    <?php foreach ($team->completedGames()->get() as $game) : ?>
    window.globalChartData.labels.push("<?php echo Str::limit($game->title, 40); ?>");
    window.globalChartData.datasets[0].data.push("<?php echo $game->home_team_id === $team->id ? $game->home_score : $game->away_score; ?>");

    <?php endforeach; ?>
</script>

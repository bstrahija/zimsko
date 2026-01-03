@extends('layouts.report')

@section('content')
    <div class="container">
        <header class="header">
            {{-- <img src="../../img/logo_ball_black.png" alt="League Logo"> --}}
            <h2>Zimsko Prvenstvo 2025</h2>
            <p>{{ $game['title'] }} </p>
        </header>

        <div class="game-result">
            <div class="game-result-flex">
                <table style="width: 100%;">
                    <tr>
                        <td class="team-name" style="text-align: left;">
                            {{ $game['home_team']['title'] }}
                        </td>
                        <td class="score" style="text-align: center; white-space: nowrap;">
                            {{ $game['home_score'] }}
                            -
                            {{ $game['away_score'] }}
                        </td>
                        <td style="text-align: right;" class="team-name">
                            {{ $game['away_team']['title'] }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="section">
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Q1</th>
                        <th>Q2</th>
                        <th>Q3</th>
                        <th>Q4</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>{{ $game['home_team']['title'] }}</strong></td>
                        <td>{{ $game['home_score_p1'] }}</td>
                        <td>{{ $game['home_score_p2'] }}</td>
                        <td>{{ $game['home_score_p3'] }}</td>
                        <td>{{ $game['home_score_p4'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ $game['away_team']['title'] }}</strong></td>
                        <td>{{ $game['away_score_p1'] }}</td>
                        <td>{{ $game['away_score_p2'] }}</td>
                        <td>{{ $game['away_score_p3'] }}</td>
                        <td>{{ $game['away_score_p4'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="section">
            <div class="player-stats">
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Team</th>
                            <th>PTS</th>
                            <th>FG%</th>
                            <th>3P%</th>
                            <th>FT%</th>
                            <th>REB</th>
                            <th>AST</th>
                            <th>STL</th>
                            <th>BLK</th>
                            <th>TO</th>
                            <th>FOUL</th>
                            <th>EFF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($game['players'] as $player)
                            <tr>
                                <td class="padding-right: 0;">
                                    <small style="text-align: right;">#{{ $player['pivot']['number'] }} </small>
                                </td>
                                <td style="text-align: left">

                                    <strong>{{ $player['name'] }}</strong>
                                </td>
                                <td style="text-align: left">{{ $player['team']['title'] }}</td>
                                <td>{{ $player['score'] }}</td>
                                <td>{{ $player['stats']['field_goals_made'] }}/{{ $player['stats']['field_goals'] }}</td>
                                <td>{{ $player['stats']['three_points_made'] }}/{{ $player['stats']['three_points'] }}</td>
                                <td>{{ $player['stats']['free_throws_made'] }}/{{ $player['stats']['free_throws'] }}</td>
                                <td>{{ $player['stats']['rebounds'] }}</td>
                                <td>{{ $player['stats']['assists'] }}</td>
                                <td>{{ $player['stats']['steals'] }}</td>
                                <td>{{ $player['stats']['blocks'] }}</td>
                                <td>{{ $player['stats']['turnovers'] }}</td>
                                <td>{{ $player['stats']['fouls'] }}</td>
                                <td>{{ $player['stats']['efficiency'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

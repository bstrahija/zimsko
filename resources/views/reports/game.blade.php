@extends('layouts.report')

@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.4;
            color: #333;
            background-color: #f9fbfd
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 1.5rem;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05)
        }

        .header {
            text-align: center;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #4a6fa5;
            padding-bottom: 0.75rem
        }

        .header img {
            height: 4rem;
            margin-bottom: 0.75rem
        }

        .header h1 {
            font-size: 1.75rem;
            font-weight: bold;
            color: #4a6fa5
        }

        .game-result {
            margin-bottom: 2rem;
            text-align: center;
            background-color: #f0f5fa;
            padding: 0.75rem;
            border-radius: 5px
        }

        .game-result-flex {
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .team-name {
            font-size: 1.25rem;
            font-weight: bold;
            color: #4a6fa5
        }

        .score {
            font-size: 2rem;
            font-weight: bold;
            margin: 0 0.75rem;
            color: #d68c45
        }

        .section {
            margin-bottom: 2rem
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            text-align: center;
            border-bottom: 1px solid #4a6fa5;
            padding-bottom: 0.4rem;
            color: #4a6fa5
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0
        }

        th,
        td {
            padding: 0.5rem;
            text-align: center;
            border-bottom: 1px solid #e6eef7
        }

        th {
            background-color: #f0f5fa;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.7rem;
            color: #4a6fa5
        }

        tr:nth-child(even) {
            background-color: #fafbfd
        }

        .player-stats {
            overflow-x: auto
        }

        .footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.8rem;
            color: #666;
            border-top: 1px solid #4a6fa5;
            padding-top: 0.75rem
        }

        .footer-line {
            display: inline-block;
            width: 40px;
            height: 2px;
            background-color: #4a6fa5;
            margin: 0 4px 8px
        }

        @media print {
            body {
                background-color: #fff
            }

            .container {
                box-shadow: none
            }

            .header h1,
            .team-name,
            .section-title,
            th {
                color: #333
            }

            .score {
                color: #555
            }

            .game-result,
            th {
                background-color: #f5f5f5
            }

            .footer-line {
                background-color: #555
            }
        }
    </style>
    <div class="container">
        <header class="header">
            <img src="{{ asset('img/logo_ball_black.png') }}" alt="League Logo">
        </header>
        <div class="game-result">
            <div class="game-result-flex">
                <h2 class="team-name">Team A</h2>
                <div class="score">85 - 78</div>
                <h2 class="team-name">Team B</h2>
            </div>
        </div>
        <div class="section">
            <h3 class="section-title">Scores per Quarter</h3>
            <table>
                <thead>
                    <tr>
                        <th>Team</th>
                        <th>Q1</th>
                        <th>Q2</th>
                        <th>Q3</th>
                        <th>Q4</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Team A</strong></td>
                        <td>22</td>
                        <td>18</td>
                        <td>25</td>
                        <td>20</td>
                        <td><strong>85</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Team B</strong></td>
                        <td>19</td>
                        <td>21</td>
                        <td>17</td>
                        <td>21</td>
                        <td><strong>78</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="section">
            <h3 class="section-title">Player Statistics</h3>
            <div class="player-stats">
                <table>
                    <thead>
                        <tr>
                            <th>Player</th>
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
                            <th>EFF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (['A', 'B'] as $team)
                            @for ($i = 1; $i <= 8; $i++)
                                <tr>
                                    <td><strong>Player {{ $i }}</strong></td>
                                    <td>Team {{ $team }}</td>
                                    <td>{{ rand(0, 30) }}</td>
                                    <td>{{ rand(30, 70) }}%</td>
                                    <td>{{ rand(20, 50) }}%</td>
                                    <td>{{ rand(60, 100) }}%</td>
                                    <td>{{ rand(0, 15) }}</td>
                                    <td>{{ rand(0, 10) }}</td>
                                    <td>{{ rand(0, 5) }}</td>
                                    <td>{{ rand(0, 3) }}</td>
                                    <td>{{ rand(0, 5) }}</td>
                                    <td>{{ rand(0, 30) }}</td>
                                </tr>
                            @endfor
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <footer class="footer">
            <div>
                <span class="footer-line"></span>
                <span class="footer-line"></span>
            </div>
            <p>© {{ date('Y') }} Zimsko Košarkaško Prvenstvo Čakovec. All rights reserved.</p>
        </footer>
    </div>
@endsection

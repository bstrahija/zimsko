<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zimsko Košarkaško Prvenstvo Čakovec</title>

    <meta name="author" content="Boris Strahija, Creo">
    <meta name="copyright" content="Zimsko Košarkaško Prvenstvo Čakovec">
    <meta name="application-name" content="Zimsko Košarkaško Prvenstvo Čakovec">
    <meta name="description"
        content="ZIMSKO KOŠARKAŠKO PRVENSTVO“Zimsko košarkaško prvenstvo” je zamišljeno kao amatersko prvenstvo u košarci koje se odigrava nedjeljom u jutarnjim satima">
    <meta name="keywords" content="zimsko, zima, košarka, prvenstvo, čakovec, međimurje, basketball">

    <style>
        body {
            font-size: 12px;
            font-family: Verdana, 'DejaVu Sans', 'Times New Roman', Arial, Helvetica, sans-serif;
            line-height: 1.4;
            color: #333;
            background-color: #f9fbfd;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 1.5rem;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .header {
            text-align: center;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #4a6fa5;
            padding-bottom: 0.75rem;
        }

        .header img {
            height: 4rem;
            margin-bottom: 0.75rem;
        }

        .header h1 {
            font-size: 1.75rem;
            font-weight: bold;
            color: #4a6fa5;
        }

        .game-result {
            margin-bottom: 2rem;
            text-align: center;
            background-color: #f0f5fa;
            padding: 0.75rem;
            border-radius: 5px;
        }

        .game-result-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .team-name {
            font-size: 1.25rem;
            font-weight: bold;
            color: rgb(1, 114, 173);
            width: 40%;
        }

        .score {
            font-size: 2rem;
            font-weight: bold;
            margin: 0 0.75rem;
            color: #ff6b00;
            width: 20%;
            text-align: center;
        }

        .section {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            text-align: center;
            border-bottom: 1px solid #4a6fa5;
            padding-bottom: 0.4rem;
            color: #4a6fa5;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        th,
        td {
            padding: 0.5rem;
            text-align: center;
            border-bottom: 1px solid #e6eef7;
        }

        th {
            background-color: #f0f5fa;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.7rem;
            color: #4a6fa5;
        }

        tr:nth-child(even) {
            background-color: #fafbfd;
        }

        .player-stats {
            overflow-x: auto;
        }

        .footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.8rem;
            color: #666;
            border-top: 1px solid #4a6fa5;
            padding-top: 0.75rem;
        }

        .footer-line {
            display: inline-block;
            width: 40px;
            height: 2px;
            background-color: #4a6fa5;
            margin: 0 4px 8px;
        }

        @media print {
            body {
                background-color: #fff;
            }

            .container {
                box-shadow: none;
            }

            .header h1,
            .team-name,
            .section-title,
            th {
                color: #333;
            }

            .score {
                color: #555;
            }

            .game-result,
            th {
                background-color: #f5f5f5;
            }

            .footer-line {
                background-color: #555;
            }
        }
    </style>
</head>

<body class="bg-white">
    @yield('content')
</body>

</html>

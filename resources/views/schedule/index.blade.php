<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Schedule</title>
    <style>
        .meeting {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div id="app">
        @isset($error)
            <p>{{ $error }}</p>
        @else
            <h1>営業時間</h1>
            <p>開始時間: {{ $data['working_hours']['start'] }}</p>
            <p>終了時間: {{ $data['working_hours']['end'] }}</p>

            <h1>ミーティングスケジュール</h1>
            @foreach ($data['meetings'] as $date => $meetings)
                <h2>{{ $date }}</h2>
                @foreach ($meetings as $meeting)
                    <div class="meeting">
                        <p>概要: {{ $meeting['summary'] }}</p>
                        <p>開始時間: {{ $meeting['start'] }}</p>
                        <p>終了時間: {{ $meeting['end'] }}</p>
                        <p>タイムゾーン: {{ $meeting['timezone'] }}</p>
                    </div>
                @endforeach
            @endforeach
        @endisset
    </div>
</body>
</html>

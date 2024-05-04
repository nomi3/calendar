<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar UI</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400&display=swap" rel="stylesheet">
    <style>
        h2 {
            font-family: 'Noto Sans', sans-serif;
            font-size: 24px;
            font-weight: 400;
            line-height: 32.69px;
            text-align: left;
            color: #424242;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            color: #424242;
            font-family: Noto Sans;
            font-size: 24px;
            font-weight: 400;
            line-height: 32.69px;
            text-align: left;
        }
        td, th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .meeting {
            background-color: #49B5A9;
            color: #fff;
            font-family: Noto Sans;
            font-size: 24px;
            font-weight: 400;
            line-height: 32.69px;
            text-align: left;
        }
    </style>
</head>
<body>
@php
    function getWeekday($date) {
        $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
        $timestamp = strtotime($date);
        return $weekdays[date('w', $timestamp)];
    }

    $dates = array_keys($data['meetings']);
@endphp
<h2>カレンダーUI</h2>
@isset($error)
<p>{{ $error }}</p>
@else
<table>
    <thead>
        <tr>
            <th></th>
            @foreach($dates as $date)
                <th>{{ date('n/j', strtotime($date)) }} ({{ getWeekday($date) }})</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach(range(strtotime($data['working_hours']['start']), strtotime($data['working_hours']['end']), 3600) as $hour)
            <tr>
                <td>{{ date('H:i', $hour) }}</td>
                @foreach($dates as $date)
                    <td>
                        @foreach($data['meetings'][$date] ?? [] as $meeting)
                            @if(strtotime($meeting['start']) == $hour)
                                <div class="meeting">
                                    {{ $meeting['summary'] }}
                                </div>
                            @endif
                        @endforeach
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
@endisset
</body>
</html>

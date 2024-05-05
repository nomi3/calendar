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
            padding: 0px;
            text-align: center;
            height: 32px;
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

        .start-hour {
            border-bottom: none;
        }
        .half-hour {
            border-top: none;
        }

        .meeting-exist {
            background-color: #49B5A9;
            color: #fff;
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
        @foreach(range(strtotime($data['working_hours']['start']), strtotime($data['working_hours']['end']), 1800) as $index => $half_hour)
            <tr>
                @if($index % 2 == 0)
                    <td class="start-hour">{{ date('H:i', $half_hour) }}</td>
                @else
                    <td class="half-hour"></td>
                @endif
                @foreach($dates as $date)
                    @php
                        $flag_meeting_start = false;
                        $flag_meeting_end = false;
                        $meeting_summary = '';
                        $class_name = $index % 2 == 0 ? 'start-hour' : 'half-hour';
                        foreach($data['meetings'][$date] ?? [] as $meeting) {
                            $meeting_start = strtotime($meeting['start']);
                            $meeting_end = strtotime($meeting['end']);
                            if ($meeting_start == $half_hour) {
                                $flag_meeting_start = true;
                            }
                            if ($meeting_end == $half_hour + 1800) {
                                $flag_meeting_end = true;
                            }
                            if ($index % 2 == 1 && $flag_meeting_start && !$flag_meeting_end) {
                                $class_name = 'start-hour';
                            }
                            if ($index % 2 == 0 && !$flag_meeting_start && $flag_meeting_end) {
                                $class_name = 'half-hour';
                            }
                        }
                    @endphp
                    @if ($flag_meeting_start)
                        <td class="meeting-exist {{$class_name}}">
                            <div class="meeting">
                                {{ $meeting['summary'] }}
                            </div>
                        </td>
                    @elseif ($flag_meeting_end)
                        <td class="meeting-exist {{$class_name}}"></td>
                    @else
                        <td class="{{$class_name}}"></td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
@endisset
</body>
</html>

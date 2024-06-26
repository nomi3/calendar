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
            font-family: 'Noto Sans', sans-serif;
            font-size: 24px;
            font-weight: 400;
            line-height: 32.69px;
            text-align: left;
        }
        td, th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            height: 32px;
            font-weight: 400;
        }

        .border-bottom-none {
            border-bottom: none;
        }
        .border-top-none {
            border-top: none;
        }

        .meeting {
            background-color: #49B5A9;
            color: #fff;
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
        @foreach(range(strtotime($data['working_hours']['start']), strtotime($data['working_hours']['end'])+1800, 1800) as $index => $half_hour)
            <tr>
                @if($index % 2 == 0)
                    <td class="border-bottom-none">{{ date('H:i', $half_hour) }}</td>
                @else
                    <td class="border-top-none"></td>
                @endif
                @foreach($dates as $date)
                    @php
                        $flag_meeting_start = false;
                        $flag_meeting_end = false;
                        $meeting_summary = '';
                        $class_name = $index % 2 == 0 ? 'border-bottom-none' : 'border-top-none';
                        foreach($data['meetings'][$date] ?? [] as $meeting) {
                            $meeting_start = strtotime($meeting['start']);
                            $meeting_end = strtotime($meeting['end']);
                            if ($meeting_start == $half_hour) {
                                $flag_meeting_start = true;
                                $meeting_summary = $meeting['summary'];
                            }
                            if ($meeting_end == $half_hour + 1800) {
                                $flag_meeting_end = true;
                            }
                            if ($index % 2 == 1 && $flag_meeting_start && !$flag_meeting_end) {
                                $class_name = 'border-bottom-none';
                            }
                            if ($index % 2 == 0 && !$flag_meeting_start && $flag_meeting_end) {
                                $class_name = 'border-top-none';
                            }
                        }
                    @endphp
                    @if ($flag_meeting_start)
                        <td class="meeting {{$class_name}}">
                            {{ $meeting_summary }}
                        </td>
                    @elseif ($flag_meeting_end)
                        <td class="meeting {{$class_name}}"></td>
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

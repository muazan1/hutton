<table style="text-align: center;margin-bottom: 10px" width="550">
    <tr>
        <td style="text-align: center;font-size: 24px;color: black;font-family: serif">
            Joiner Weekly Work Report
        </td>
    </tr>
    <tr>
        <td>
            Joiner Name: {{ $data->joiner->first_name.' '.$data->joiner->last_name }}
        </td>
    </tr>
    <tr>
        <td>
             Week Start: {{ $data->week_start }}
        </td>
    </tr>
</table>

<table style="text-align: center;margin-bottom: 10px" width="550">
    <tr>
        <td style="text-align: center;font-size: 20px;color: black;font-family: serif">
            Weekly Work
        </td>
    </tr>
</table>

<table style="border-collapse: collapse;border:1px solid black;" width="550">
    <thead>
        <tr>
            <th style="border: 1px solid black;">
                Site
            </th>
            <th style="border: 1px solid black;">
                Plot
            </th>
            <th style="border: 1px solid black;">
                Service
            </th>
            <th style="border: 1px solid black;">
                Amount
            </th>
            <th style="border: 1px solid black;">
                Time Taken
            </th>
            <th style="border: 1px solid black;">
                Work Carried Out
            </th>
        </tr>
    </thead>
    <tbody>
        @if($data->dailyWork != null)
            @foreach($data->dailyWork as $work)
                <tr>
                    <td style="border: 1px solid black;padding: 5px;">
                        {{$work->plot->buildingType->site->site_name}}
                   </td>
                    <td style="border: 1px solid black;padding: 5px;">
                        {{$work->plot->plot_name}}
                    </td>
                    <td style="border: 1px solid black;padding: 5px;">
                        {{$work->service->service_name}}
                    </td>
                    <td style="border: 1px solid black;padding: 5px;">
                        {{'£'.$work->amount}}
                    </td>
                    <td style="border: 1px solid black;padding: 5px;">
                        {{$work->time_taken}}
                    </td>
                    <td style="border: 1px solid black;padding: 5px;">
                        {{$work->work_carried}}
                    </td>

                </tr>
            @endforeach
        @endif
    </tbody>
</table>


<table style="text-align: center;margin-bottom: 10px" width="550">
    <tr>
        <td style="text-align: center;font-size: 20px;color: black;font-family: serif">
            Miscellaneous Work
        </td>
    </tr>
</table>

<table style="border-collapse: collapse;border:1px solid black;" width="550">
    <thead>
    <tr>
        <th style="border: 1px solid black;">
            Title
        </th>
        <th style="border: 1px solid black;">
            Amount
        </th>
        <th style="border: 1px solid black;">
            Time Taken
        </th>
        <th style="border: 1px solid black;">
            Work Carried Out
        </th>
    </tr>
    </thead>
    <tbody>
    @if($data->miscWork != null)
        @foreach($data->miscWork as $work)
            <tr>
                <td style="border: 1px solid black;padding: 5px;">
                    {{$work->title}}
                </td>
                <td style="border: 1px solid black;padding: 5px;">
                    {{'£'.$work->amount}}
                </td>
                <td style="border: 1px solid black;padding: 5px;">
                    {{$work->time_taken}}
                </td>
                <td style="border: 1px solid black;padding: 5px;">
                    {{$work->work_carried}}
                </td>

            </tr>
        @endforeach
    @endif
    </tbody>
</table>

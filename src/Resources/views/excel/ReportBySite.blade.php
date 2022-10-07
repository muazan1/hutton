<table>
    <tr style="font-weight: bold">
        <td style="font-weight: bold">
            {{'Site'}}
        </td>
        <td style="font-weight: bold">
            {{'Plot'}}
        </td>
        <td style="font-weight: bold">
            {{'Fix'}}
        </td>
        <td style="font-weight: bold">
            {{'Joiner'}}
        </td>
        <td style="font-weight: bold">
            {{'Amount'}}
        </td>
        <td style="font-weight: bold">
            {{'Time Taken'}}
        </td>
        <td style="font-weight: bold">
            {{'Fix Perform'}}
        </td>

    </tr>

    @if($data->count() > 0)
        @foreach($data as $index => $value)
{{--    {{dd($value)}}--}}
            <tr>
                <td>
                    {{ $value['plot']['buildingType']['site']['site_name'] }}
                </td>
                <td>
                    {{ $value['plot']['plot_name'] }}
                </td>
                <td>
                    {{ $value['service']['service_name'] }}
                </td>
                <td>
                    {{ $value['weeklyWork']['joiner']['first_name'].' '.$value['weeklyWork']['joiner']['last_name'] }}
                </td>
                <td>
                    {{ "£" . $value['amount'] }}
                </td>
                <td>
                    {{ $value['time_taken'] }}
                </td>
                <td>
                    {{ $value['work_carried'] }}
                </td>

            </tr>
        @endforeach
    @endif
</table>

<table>
    <tr>
        <td style="font-weight: bold;width: 100% !important;">
            {{'Site'}}
        </td>
        <td style="font-weight: bold;width: 100% !important;">
            {{'Joiner'}}
        </td>
        <td style="font-weight: bold;width: 100% !important;">
            {{'Service'}}
        </td>
        <td style="font-weight: bold;width: 100% !important;">
            {{'Date & Time'}}
        </td>
{{--        <td style="font-weight: bold">--}}
{{--            {{'Joiner Price'}}--}}
{{--        </td>--}}
{{--        <td style="font-weight: bold">--}}
{{--            {{'Service Price'}}--}}
{{--        </td>--}}
{{--        <td style="font-weight: bold">--}}
{{--            {{'MD Hutton Profit'}}--}}
{{--        </td>--}}
    </tr>

    @if($data->count() > 0)
        @foreach($data as $index => $value)
{{--    {{dd($value->jobjoiner[0])}}--}}
            <tr>
                <td style="width: 100% !important;">
                    {{ $value->plot->buildingType->site->site_name }}
                </td>
                <td style="width: 100% !important;">
                    {{ $value->jobjoiner != NULL ?
                        $value->jobjoiner->first_name.' '.$value->jobjoiner->last_name :'' }}
                </td>
                <td style="width: 100% !important;">
                    {{ $value->service->service_name }}
                </td>
                <td style="width: 100% !important;">
                    {{ \Carbon\Carbon::parse($value->updated_at)->format('d/m/Y H:i:s A') }}
                </td>
{{--                <td>--}}
{{--                    {{'Joiner Price'}}--}}
{{--                </td>--}}
{{--                <td>--}}
{{--                    {{'Service Price'}}--}}
{{--                </td>--}}
{{--                <td>--}}
{{--                    {{'MD Hutton Profit'}}--}}
{{--                </td>--}}
            </tr>
        @endforeach
    @endif
</table>

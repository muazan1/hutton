<table>
    <tr>
        <td>
            {{'Site'}}
        </td>
        <td>
            {{'Joiner'}}
        </td>
        <td>
            {{'Service'}}
        </td>
        <td>
            {{'Date & Time'}}
        </td>
        <td>
            {{'Joiner Price'}}
        </td>
        <td>
            {{'Service Price'}}
        </td>
        <td>
            {{'MD Hutton Profit'}}
        </td>
    </tr>

    @if($data->count() > 0)
        @foreach($data as $index => $value)
            <tr>
                <td>
                    {{ $value->plot->buildingType->site->site_name }}
                </td>
                <td>
                    {{'Joiner'}}
                </td>
                <td>
                    {{ $value->service->service_name }}
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($value->updated_at)->format('d/m/Y H:i:s A') }}
                </td>
                <td>
                    {{'Joiner Price'}}
                </td>
                <td>
                    {{'Service Price'}}
                </td>
                <td>
                    {{'MD Hutton Profit'}}
                </td>
            </tr>
        @endforeach
    @endif
</table>

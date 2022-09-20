<table>
    <tr style="font-weight: bold">
        <td style="font-weight: bold">
            {{'Service'}}
        </td>
        <td style="font-weight: bold">
            {{'Plot'}}
        </td>
        <td style="font-weight: bold">
            {{'Building Type'}}
        </td>
        <td style="font-weight: bold">
            {{'Site'}}
        </td>
        <td style="font-weight: bold">
            {{'Builder'}}
        </td>
        <td style="font-weight: bold">
            {{'Status'}}
        </td>
    </tr>

    @if($data->count() > 0)
        @foreach($data as $index => $value)
            <tr>
                <td>
                    {{ $value->service->service_name }}
                </td>
                <td>
                    {{ $value->plot->plot_name }}
                </td>
                <td>
                    {{ $value->plot->buildingType->building_type_name }}
                </td>
                <td>
                    {{ $value->plot->buildingType->site->site_name  }}
                </td>
                <td>
                    {{$value->plot->buildingType->site->builder->customer_name}}
                </td>
                <td>
                    {{ $value->status }}
                </td>
            </tr>
        @endforeach
    @endif
</table>

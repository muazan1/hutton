<table>
    <tr>
        <td>
            {{'Joiner Name'}}
        </td>
        <td>
            {{'Amount Paid'}}
        </td>
    </tr>

    @if($data->count() > 0)
        @foreach($data as $index => $value)
            <tr>
                <td>
                    {{ $value['joiner_name'] }}
                </td>

                <td>
                    {{ '£'.$value['total_amount'] }}
                </td>
            </tr>
        @endforeach
    @endif
</table>

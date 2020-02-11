<h5>Selected Items</h5>
@foreach($selectedData as $key => $data)
    @foreach($data as $key => $value)
        <ul>
           <li>{{$value}}</li>
        </ul>
    @endforeach
@endforeach

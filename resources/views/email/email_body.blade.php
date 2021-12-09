@component('mail::message')
# Order
<table>
    <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Price</th>
        <th>Image</th>
    </tr>
    @foreach ($products as $product)
        <tr>
            <td>{{ $product->title }}</td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->price }}</td>
            <td><img style="width: 30px; height: 30px;" src="{{ URL::to('http://127.0.0.1:8000/storage/images/') }}/{{ $product->image }}"/></td>
        </tr>
    @endforeach
</table>
<p>Name: {{ $name }}</p>
<p>Email: {{ $email }}</p>
<p>Comments: {{ $comments }}</p>
@endcomponent

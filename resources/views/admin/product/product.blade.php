 <tr>
    <td> {{ $product->id }} </td>
    <td> {{ $product->title }} </td>
    <td> ${{ $product->price }} </td>
    <td><img src="{{asset('storage/'. $product->image)}}" alt=""> {{ $product->image }} </td>
    <td class="fx-action-links text-center">
        <div class="action-group">
            <a href="{{url('/admin/products/'.$product->id.'/edit')}}" class="action edit"></a>
             <form method="post" class="delete-form" action="{{ route('products.destroy', $product->id) }}">
                @method('delete')
                @csrf
                <input type="submit" value="Delete" class="delete-action-form">
             </form>
        </div>
    </td>
</tr>

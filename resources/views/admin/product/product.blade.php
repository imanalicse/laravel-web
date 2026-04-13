 <tr>
    <td> {{ $product->id }} </td>
    <td> {{ $product->name }} </td>
    <td> ${{ $product->price }} </td>
    <td><img src="{{asset('storage/'. $product->image)}}" alt=""> {{ $product->image }} </td>
    <td class="fx-action-links text-center">
        <div class="btn-group" role="group" aria-label="Basic example">
            <a href="{{url('/admin/products/'.$product->id.'/edit')}}" class="btn btn-light">Edit</a>
             <form method="post" class="delete-form" action="{{ route('products.destroy', $product->id) }}">
                @method('delete')
                @csrf
                <input type="submit" value="Delete" class="btn btn-light">
             </form>
        </div>
    </td>
</tr>

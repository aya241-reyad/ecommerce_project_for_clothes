 <div class="container mt-3">

     <div class="card">
         <div class="card-header">
             <h3>products
                 <a href="{{ route('products.create') }}" class="btn btn-primary float-end btn-sm text-white  ">Add
                     product</a>


             </h3>
         </div>
         <div class="card-body">
             <input type="search" wire:model="search" class="form-control float-end mx-10" placeholder="Search..."
                 style="width: 230px; margin-bottom:10px;" />

             <table id="example" class="table  text-center">
                 <thead>
                     <tr>
                         <th>title</th>
                         <th>quantity</th>
                         <th>category</th>
                         <th>price</th>
                         <th>discount</th>
                         <th>price after discount</th>
                         <th>Featured</th>
                         <th>actions</th>
                     </tr>
                 </thead>
                 <tbody class="table-border-bottom-0">

                     @forelse($products as $product)
                         @include('products.modal')
                         <tr>
                             <td> {{ $product->title }} </td>
                             <td> {{ $product->quantity }} </td>
                             <td> {{ $product->category->name ?? null }} </td>
                             <td> {{ $product->price }} </td>
                             <td> {{ $product->tax }} </td>
                             <td> {{ $product->price_after_tax }} </td>
                             <td>

                                 <input type="checkbox" data-id="{{ $product->id }}"
                                     {{ $product->is_featured ? 'checked' : '' }} class="toggle-class form-check-input"
                                     checked data-toggle="toggle" data-style="ios">



                             </td>


                             <td>


                                 <a class="btn btn-sm round btn-outline-primary"
                                     href="{{ route('products.edit', $product->id) }}"><i
                                         class="fa-solid fa-pen-to-square"></i></i>
                                 </a>

                                 <a class="btn btn-sm round btn-outline-primary"
                                     href="{{ route('products.show', $product->id) }}"><i
                                         class="fa-solid fa-bars"></i></i>
                                 </a>
                                 <span class=" btn btn-sm round btn-outline-danger delete-row text-danger"
                                     data-url="{{ url('products/' . $product->id) }}"><i
                                         class="fa-solid fa-trash"></i></span>


                             </td>
                         </tr>
                     @empty
                         <tr class="text-center">
                             <td colspan="7">No Data</td>
                         </tr>
                     @endforelse

                 </tbody>
             </table>

         </div>
         {{ $products->links() }}
     </div>



 </div>
 </div>

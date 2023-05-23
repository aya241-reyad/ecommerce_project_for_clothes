@extends('dashboard.master')

@section('content')
    @include('dashboard.alerts.alerts')

    <div class="container mt-3">

        <div class="card">
            <div class="card-header">
                <h3>Colors
                    <a href="{{ url('color/create') }}" class="btn btn-primary float-end btn-sm text-white  ">Add
                        color</a>


                </h3>
            </div>
            <table class="table table-borderd text-center">
                <thead>
                    <tr>
                        <th>Color</th>
                        <th>Code</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0 ">
                    @forelse ($colors as $color)
                        @include('colors.modal')

                        <tr>
                            <td>{{ $color->name }}</td>
                            <td>{{ $color->code }}</td>

                            <td>

                                <input type="checkbox" data-id="{{ $color->id }}" {{ $color->status ? 'checked' : '' }}
                                    class="toggle-class form-check-input" checked data-toggle="toggle" data-style="ios">


                            <td>
                                <a class="btn btn-sm round btn-outline-primary"
                                    href="{{ route('color.edit', $color->id) }}"><i
                                        class="fa-solid fa-pen-to-square"></i></i>
                                </a>
                                <span class=" btn btn-sm round btn-outline-danger delete-row text-danger"
                                    data-url="{{ url('color/delete/' . $color->id) }}"><i
                                        class="fa-solid fa-trash"></i></span>



                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No Data</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('.toggle-class').change(function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var color_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: 'Backend/change/status/color',
                    data: {
                        'status': status,
                        'color_id': color_id
                    },
                    success: function(data) {
                        console.log(data.success)
                    }
                });
            })
        })
    </script>

    <script src="{{ asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js') }}"></script>

    {{-- delete one user script --}}
    @include('dashboard.shared.deleteOne')
    {{-- delete one user script --}}
@endsection

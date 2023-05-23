@extends('dashboard.master')

@section('content')
    @include('dashboard.alerts.alerts')

    <div class="container mt-3">

        <div class="card">
            <div class="card-header">
                <h3>sliders
                    <a href="{{ route('sliders.create') }}" class="btn btn-primary float-end btn-sm text-white  ">Add
                        slider</a>
                </h3>
            </div>
            <table class="table table-light text-center">
                <thead>
                    <tr>
                        <th>title</th>
                        <th>description</th>
                        <th>status</th>
                        <th>image</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">


                    @forelse($sliders as $slider)
                        <tr>
                            <td> {{ $slider->title }} </td>
                            <td> {{ $slider->description }} </td>
                            <td>


                                <input type="checkbox" data-id="{{ $slider->id }}" {{ $slider->status ? 'checked' : '' }}
                                    class="toggle-class form-check-input" checked data-toggle="toggle" data-style="ios">



                            </td>


                            <td><img src="{{ asset($slider->attachmentRelation[0]->path) }}"width="50" height="50">
                            </td>
                            <td>

                                <a class="btn btn-sm round btn-outline-primary"
                                    href="{{ route('sliders.edit', $slider->id) }}"><i
                                        class="fa-solid fa-pen-to-square"></i></i>
                                </a>


                                <span class=" btn btn-sm round btn-outline-danger delete-row text-danger"
                                    data-url="{{ url('sliders/' . $slider->id) }}"><i class="fa-solid fa-trash"></i></span>



                            </td>






                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No data</td>
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

                var slider_id = $(this).data('id');

                $.ajax({

                    type: "GET",

                    dataType: "json",

                    url: '/Backend/change-slider-status',

                    data: {
                        'status': status,
                        'id': slider_id
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

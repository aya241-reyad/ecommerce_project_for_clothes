@extends('dashboard.master')
@section('title')
    clients page
@endsection
@section('content')
    <div class="container mt-3">
        <div class="card ">
            <h5 class="card-header">Clients</h5>
            @include('dashboard.alerts.alerts')
            <div class="table-responsive text-nowrap">
                <table class="table table-light">
                    <thead>
                        <tr>
                            <th>name </th>
                            <th>email</th>
                            <th>status</th>
                            <th>actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                        @forelse($clients as $client)
                            <tr>
                                <td> {{ $client->user_name }} </td>
                                <td> {{ $client->email }} </td>
                                <td>


                                    <input type="checkbox" data-id="{{ $client->id }}"
                                        {{ $client->status ? 'checked' : '' }} class="toggle-class form-check-input" checked
                                        data-toggle="toggle" data-style="ios">


                                </td>

                                <td>
                                    <span class=" btn btn-sm round btn-outline-danger delete-row text-danger"
                                        data-url="{{ url('clients/' . $client->id) }}"><i
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
                <script>
                    $(function() {

                        $('.toggle-class').change(function() {

                            var is_active = $(this).prop('checked') == true ? 1 : 0;

                            var client_id = $(this).data('id');

                            $.ajax({

                                type: "GET",

                                dataType: "json",

                                url: '/client-change-status',

                                data: {
                                    'status': is_active,
                                    'id': client_id
                                },

                                success: function(data) {

                                    console.log(data.success)

                                }

                            });
                        })

                    })
                </script>




            </div>
        </div>
    </div>

    <script src="{{ asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js') }}"></script>

    {{-- delete one user script --}}
    @include('dashboard.shared.deleteOne')
    {{-- delete one user script --}}
@endsection

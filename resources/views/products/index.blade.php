@extends('dashboard.master')

@section('content')
    @include('dashboard.alerts.alerts')

   <div>
       <livewire:products.product-search>

   </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('.toggle-class').change(function() {
                var is_featured = $(this).prop('checked') == true ? 1 : 0;
                var product_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '/Backend/change/status/featured',
                    data: {
                        'is_featured': is_featured,
                        'product_id': product_id
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


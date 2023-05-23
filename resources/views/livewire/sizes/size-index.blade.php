@include('dashboard.alerts.alerts')

<div class="container mt-3">
    @include('livewire.sizes.modal2')

    <div class="card">
        <div class="card-header">
            <h3>Colors
                <button type="button" class="btn btn-primary float-end btn-sm text-white" data-bs-toggle="modal"
                    data-bs-target="#basicModal">
                    Add Size
                </button>


            </h3>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>size</th>

                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sizes as $item)

                        <tr>
                            <td>{{ $item->size }}</td>
                            <td>
                                <span class="btn btn-sm round btn-outline-danger" data-id={{ $item->id }}
                                    class="btn btn-danger delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal"><i class="fa-solid fa-trash"></i></span>
                            </td>
                        </tr>

                        

                    @endforeach

                </tbody>

            </table>
        </div>
    </div>
</div>



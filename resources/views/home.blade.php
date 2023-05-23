@extends('dashboard.master')
@section('title')
    home page
@endsection
@inject('products', 'App\Models\Product')
@inject('orders', 'App\Models\Order')
@inject('clients', 'App\Models\Client')
@inject('category', 'App\Models\Category')
@include('modal')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper container">
        
        <!-- Content -->
        @include('dashboard.alerts.alerts')
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-8 mb-4 order-0">
                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-7">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">Congratulations {{ Auth::user()->name }}! 🎉</h5>
                                    <p class="mb-4">
                                        You have done <span class="fw-bold">{{$differenceInpercentage1}}</span> more sales today. Check your new
                                        badge in
                                        your profile.
                                    </p>

                                    <a  class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">Profile</a>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
                                    <img src="{{ asset('backend/img/illustrations/man-with-laptop-light.png') }}"
                                        height="140" alt="View Badge User"
                                        data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                        data-app-light-img="illustrations/man-with-laptop-light.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 order-1">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-6 mb-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="card-title d-flex align-items-start justify-content-center">
                                        <div class="avatar flex-shrink-0 avatarCart">
                                            <i class="menu-icon tf-icons bx bx-cart"></i>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1">Products</span>
                                    <h3 class="card-title mb-2">{{ $products->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-6 mb-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="card-title d-flex align-items-start justify-content-center">
                                        <div class="avatar flex-shrink-0 avatarCart">
                                            <i class="menu-icon tf-icons bx bx-store"></i>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1">Orders</span>
                                    <h3 class="card-title text-nowrap mb-1">{{ $orders->count() }}</h3>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Total Revenue -->
                <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                    <div class="card">
                        <div class="row row-bordered g-0">
                            <div class="col-md-12">
                                <h5 class="card-header m-0 me-2 pb-3">Total Revenue</h5>
                                <div  class="px-2">                                                           {!! $chart1->renderHtml() !!}
</div>
                            </div>
                           
                        </div>
                    </div>
                </div>
                <!--/ Total Revenue -->
                <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                    <div class="row">
                        <div class="col-6 mb-4">
                            <div class="card text-center">
                                <div class="card-body text-center">
                                    <div class="card-title d-flex align-items-start justify-content-center">
                                        <div class="avatar flex-shrink-0 avatarCart">
                                            <i class="menu-icon tf-icons bx bxs-user-detail"></i>
                                        </div>
                                    </div>

                                    <span class="fw-semibold d-block mb-1">Clients</span>
                                    <h3 class="card-title text-nowrap mb-2">{{ $clients->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="card-title d-flex align-items-start justify-content-center">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('backend/img/icons/unicons/cc-primary.png') }}"
                                                alt="Credit Card" class="rounded" />
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1">Categories</span>
                                    <h3 class="card-title mb-2">{{$category->count()}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- </div>
                            <div class="row"> -->
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                    <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                        <div class="card-title">
                                            <h5 class="text-nowrap mb-2">Profile Report</h5>
                                            <span class="badge bg-label-warning rounded-pill">{{Carbon\Carbon::parse($sales[0]->month ?? 0)->format('F') ?? null}}</span>
                                        </div>
                                        <div class="mt-sm-auto">
                                            <small class="text-success text-nowrap fw-semibold"><i
                                                    class="bx bx-chevron-up"></i>{{$differenceInpercentage}}</small>
                                            <h3 class="mb-0">${{number_format($sales[0]->price ?? 0)}}k</h3>
                                        </div>
                                    </div>
                                    <div id="profileReportChart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Order Statistics -->
            <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Order Statistics</h5>
                            <small class="text-muted">{{number_format($orders->sum('total'))}} Total Sales</small>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                                <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item" href="javascript:void(0);">Share</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex flex-column align-items-center gap-1">
                                <h2 class="mb-2">{{number_format($orders->sum('total'))}}</h2>
                                <span>Total Orders</span>
                            </div>
                            <div style="display: block;height: 150px;width: 150px; margin-left:30px;">
                                                                {!! $chart2->renderHtml() !!}

                            </div>
                        </div>
                        <ul class="p-0 m-0">
                            @foreach($order as $item)
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class="avatar-initial rounded bg-label-primary"><i
                                            class="bx bx-mobile-alt"></i></span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">{{$item->category->name ?? null}}</h6>
                                    </div>
                                    <div class="user-progress">
                                        <small class="fw-semibold">{{number_format($item->total)}}$</small>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                         
                            
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Order Statistics -->

          <!-- Total Revenue -->
                <div class="col-12 col-lg-8 order-2 order-md-6 order-lg-2 mb-4">
                    <div class="card">
                        <div class="row row-bordered g-0">
                            <div class="col-md-12">
                                <h5 class="card-header m-0 me-2 pb-3">Users</h5>
                                <div  class="px-2">                                                           {!! $chart3->renderHtml() !!}
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
                <!--/ Total Revenue -->
        </div>
    </div>
    <!-- / Content -->
    
@endsection

@section('scripts')
{!! $chart1->renderChartJsLibrary() !!}

{!! $chart1->renderJs() !!}
{!! $chart2->renderJs() !!}
{!! $chart3->renderJs() !!}


@endsection
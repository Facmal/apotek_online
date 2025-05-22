@extends('be.master')
@section('sidebar')
@include('be.sidebar')
@endsection
@section('navbar')
@include('be.navbar')
@endsection
@section('content')
<div class="container-fluid p-4">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="row">
                <div class="col-xl-6 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{ $userCount }}</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-success">
                                        <i class="mdi mdi-account-multiple text-success"></i>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">Total Users</h6>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{ $customerCount }}</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-primary">
                                        <i class="mdi mdi-account-group text-primary"></i>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">Total Customers</h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add this new section for the chart -->
            <div class="row mt-4">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Pertumbuhan Pelanggan (7 Hari Terakhir)</h4>
                            <canvas id="customerGrowthChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add this after the chart section -->
            <div class="row mt-4">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title mb-0">Daftar Users</h4>
                                <div class="d-flex align-items-center">
                                    <!-- Add this before the roleFilter select -->
                                    <a href="{{ route('admin.download-pdf', ['role' => $currentRole]) }}" 
                                       class="btn btn-danger mr-3">
                                        <i class="mdi mdi-file-pdf"></i> Download PDF
                                    </a>
                                    
                                    <div class="form-group mb-0">
                                        <select class="form-control" id="roleFilter" onchange="this.form.submit()" name="role" form="filterForm">
                                            <option value="all" {{ $currentRole == 'all' ? 'selected' : '' }}>Semua Jabatan</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role }}" {{ $currentRole == $role ? 'selected' : '' }}>
                                                    {{ ucfirst($role) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <form id="filterForm" action="{{ route('admin.index') }}" method="GET"></form>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Foto</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Jabatan</th>
                                            <th>Tanggal Bergabung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $index => $user)
                                        <tr>
                                            <td>{{ $users->firstItem() + $index }}</td>
                                            <td>
                                                @if($user->img_profile)
                                                    <img src="{{ asset('storage/' . $user->img_profile) }}" alt="profile" class="rounded-circle" width="40">
                                                @else
                                                    <span>No Image</span>
                                                @endif
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="badge badge-{{ 
                                                    $user->jabatan == 'admin' ? 'danger' : 
                                                    ($user->jabatan == 'pemilik' ? 'primary' : 
                                                    ($user->jabatan == 'apoteker' ? 'success' : 
                                                    ($user->jabatan == 'kasir' ? 'warning' : 
                                                    ($user->jabatan == 'kurir' ? 'info' : 'secondary')))) 
                                                }}">
                                                    {{ ucfirst($user->jabatan) }}
                                                </span>
                                            </td>
                                            <td>{{ $user->created_at->format('d M Y') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data user</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                {{ $users->withQueryString()->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('customerGrowthChart').getContext('2d');
    const dates = {!! $chartDates !!};
    const counts = {!! $chartCounts !!};

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Jumlah Pelanggan Baru',
                data: counts,
                borderColor: 'rgb(66, 153, 225)',
                backgroundColor: 'rgba(66, 153, 225, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>

<style>
.icon-box-success, .icon-box-primary {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}
.icon-box-success {
    background: rgba(0, 210, 91, 0.1);
}
.icon-box-primary {
    background: rgba(66, 153, 225, 0.1);
}
.icon-box-success i, .icon-box-primary i {
    font-size: 24px;
}
.grid-margin {
    margin-bottom: 2rem;
}
.card {
    border: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: transform 0.2s, box-shadow 0.2s;
    margin: 1rem 0;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}
.card-body {
    padding: 2rem;
}
.container-fluid {
    min-height: calc(100vh - 70px); /* Adjust based on your navbar height */
    background-color: #f8f9fa;
}
.card-title {
    color: #333;
    font-size: 1.25rem;
    font-weight: 500;
    margin-bottom: 1.5rem;
}

#customerGrowthChart {
    min-height: 300px;
}

.table img {
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.badge {
    padding: 0.5em 1em;
    font-weight: 500;
}

#roleFilter {
    min-width: 150px;
    height: 38px;
}

.table-hover tbody tr:hover {
    background-color: rgba(66, 153, 225, 0.05);
}

.btn-danger {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-danger i {
    font-size: 18px;
}

@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }

    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    #roleFilter {
        width: 100%;
    }

    .d-flex.align-items-center {
        flex-direction: column;
        gap: 1rem;
    }
    
    .btn-danger {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection

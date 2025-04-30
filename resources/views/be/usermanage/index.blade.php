@extends('be.master')
@section('sidebar')
@include('be.sidebar')
@endsection
@section('navbar')
@include('be.navbar')
@endsection
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card card-container">
        <div class="card-body">
            <h1 class="card-title" style="font-size: 2.5rem; font-weight: bold; color: blue;">User Management</h1>

            <div class="mb-3">
                <form action="{{ route('usermanage.index') }}" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ $search ?? '' }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
                @if (!empty($search))
                <div>
                    <a href="{{ route('usermanage.index') }}" class="btn btn-secondary">Clear Search</a>
                </div>
                @endif
            </div>
            <div class="d-flex justify-content-end mb-3">
                <a href="{{route('usermanage.create')}}" type="button" class="btn btn-inverse-primary btn-fw"> New User </a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Profile Image</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Email</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">No users found</td>
                        </tr>
                        @else
                        @foreach ($users as $nmr => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $nmr }}</td>
                            <td>
                                @if ($user['img_profile'])
                                <img src="{{ asset('storage/' . $user['img_profile']) }}" alt="Profile Image" style="width: 50px; height: 50px; border-radius: 50%;">
                                @else
                                <span>No Image</span>
                                @endif
                            </td>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['jabatan'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('usermanage.edit', $user) }}" class="btn btn-warning btn-sm"><i class="mdi mdi-table-edit"></i> Edit</a>
                                    <a href="{{ route('usermanage.destroy', $user) }}" onclick="hapus(event, this)" class="btn btn-danger btn-sm"><i class="mdi mdi-delete-forever"></i> Delete</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $users->appends(['search' => $search])->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

<form action="" method="POST" id="delete">
    @method('delete')
    @csrf
</form>

<script>
    const body = document.getElementById('body')
    const form = document.getElementById('delete')

    function hapus(event, el) {
        event.preventDefault()
        swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false,

            },
            function() {
                form.setAttribute('action', el.getAttribute('href'))
                form.submit()
            });
    }

    function tampil_pesan() {
        const pesan = "{{session('pesan')}}"

        if (pesan.trim() !== '') {
            swal('Good Job', pesan, 'success')
        }
    }

    body.onload = function() {
        tampil_pesan()
    }
</script>
@endsection

<style>
    .card-container {
        width: 100%;
        margin-top: 20px;
    }

    .table th,
    .table td {
        vertical-align: middle;
        text-align: center;
    }

    .btn-group .btn {
        margin-right: 5px;
    }

    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>
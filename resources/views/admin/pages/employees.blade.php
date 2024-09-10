@extends('admin.layouts.admin')

@section('content')
    @inject('carbon', 'Carbon\Carbon')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Employees Details Table</h4>
                        <a href="{{ route('admin.create.employee') }}" class="btn btn-primary">Add New employee</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> ID </th>
                                    <th> Name </th>
                                    <th> Email </th>
                                    <th> Profile </th>
                                    <th> Status </th>
                                    <th> Profile Completed</th>
                                    <th> Created Date</th>
                                    <th class=" text-center"> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $key =>$value)
                                    <tr>
                                        <td class="py-1">
                                            {{ $value->id }}
                                        </td>
                                        <td> {{ $value->user_name }} </td>
                                        <td> {{ $value->email }} </td>
                                        <td> {{ $value->profile }}</td>
                                        <td>
                                            <div
                                                class="badge badge-{{ $value->status == 'active' ? 'success' : 'danger' }}">
                                                {{ Str::ucfirst($value->status) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                class="badge badge-{{ $value->is_profile_completed ? 'success' : 'warning' }}">
                                                {{ $value->is_profile_completed ? 'Yes' : 'No' }}
                                            </div>
                                        </td>
                                        <td> {{ $carbon->parse($value->created_at)->format('d M , Y') }}</td>
                                        <td>
                                            <div class="d-flex justify-content-around">
                                                <a href="{{ route('edit.employee', ['id' => $value->id]) }}"><i
                                                        class="fa fa-pencil"></i></a>
                                                <a href="{{ route('delete.employee', ['id' => $value->id]) }}"
                                                    onclick=" return confirm('Are you sure?')"><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <p>No data found</p>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $data->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

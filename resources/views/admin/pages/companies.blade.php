@extends('admin.layouts.admin')

@section('content')
    @inject('carbon', 'Carbon\Carbon')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">

                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Company Details Table</h4>
                        <a href="{{ route('admin.create.company') }}" class="btn btn-primary">Create company</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> ID </th>
                                    <th> Company name </th>
                                    <th> Email </th>
                                    <th> Status </th>
                                    <th> Job Added</th>
                                    <th> Company Type </th>
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
                                        <td> {{ $value->company_name }} </td>
                                        <td> {{ $value->email }} </td>
                                        <td>
                                            <div
                                                class="badge badge-{{ $value->status == 'active' ? 'success' : 'danger' }}">
                                                {{ Str::ucfirst($value->status) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="badge badge-warning">
                                                {{ $value->job_count }}
                                            </div>
                                        </td>
                                        <td> {{ $value->company_type }}</td>
                                        <td>
                                            <div
                                                class="badge badge-{{ $value->is_profile_completed ? 'success' : 'warning' }}">
                                                {{ $value->is_profile_completed ? 'Yes' : 'No' }}
                                            </div>
                                        </td>
                                        <td> {{ $carbon->parse($value->created_at)->format('d M , Y') }}</td>
                                        <td>
                                            <div class="d-flex justify-content-around">
                                                <a href="{{ route('edit.company', ['id' => $value->id]) }}"><i
                                                        class="fa fa-pencil"></i></a>
                                                <a href="{{ route('delete.company', ['id' => $value->id]) }}"
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
                            <div class="mt-3">
                                {{ $data->links() }}
                            </div>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('admin.layouts.admin')

@section('content')
    @inject('carbon', 'Carbon\Carbon')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">

            <div class="card">
                <div class="card-body">
                    <form action="" class="search-form">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="company" id="company" class="form-control">
                                        <option value="" selected disabled>Company</option>
                                        @foreach ($data['companies'] as $company)
                                            <option value="{{ $company->id }}"
                                                {{ request()->company == $company->id ? 'selected' : '' }}>
                                                {{ $company->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="category" id="category" class="form-control">
                                        <option value="" selected disabled>Job Category</option>
                                        @foreach ($data['job_categories'] as $category)
                                            <option value="{{ $category->id }}"
                                                {{ request()->category == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="type" id="type" class="form-control">
                                        <option value="" selected disabled>Job Type</option>
                                        @foreach ($data['job_types'] as $type)
                                            <option value="{{ $type->name }}"
                                                {{ request()->type == $type->name ? 'selected' : '' }}>
                                                {{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="industry" id="industry" class="form-control">
                                        <option value="" selected disabled>Job Industry</option>
                                        @foreach ($data['job_industries'] as $type)
                                            <option value="{{ $type->id }}"
                                                {{ request()->industry == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group form-submit">
                                    <input type="submit" class="btn btn-primary" value="Search">
                                </div>
                            </div>
                        </div>
                    </form>

                    <h4 class="card-title">Jobs Details Table</h4>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> ID </th>
                                    <th> Title </th>
                                    <th> Location </th>
                                    <th> Status </th>
                                    <th> By Company </th>
                                    <th> Created Date</th>
                                    <th> DeadLine</th>
                                    <th class=" text-center"> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data['jobs'] as $key =>$value)
                                    <tr>
                                        <td class="py-1">
                                            {{ $value->id }}
                                        </td>
                                        <td> {{ $value->title }} </td>
                                        <td> {{ $value->location }} </td>
                                        <td>
                                            <div class="badge badge-{{ $value->status == 1 ? 'success' : 'danger' }}">
                                                {{ $value->status == 1 ? 'Published ' : 'Deleted' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="badge badge-primary">
                                                {{ $value->company->company_name }}
                                            </div>
                                        </td>
                                        <td> {{ $carbon->parse($value->created_at)->format('d M , Y') }}</td>
                                        <td>
                                            <div class="badge badge-warning">
                                                {{ $carbon->parse($value->deadline)->format('d M , Y') }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('edit.job', ['id' => $value->id]) }}"><i
                                                        class="fa fa-pencil"></i></a>
                                                <a href="{{ route('delete.job', ['id' => $value->id]) }}"
                                                    onclick="return confirm('Are you sure?')"><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                <p>No data found</p>
                                @endforelse

                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $data['jobs']->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

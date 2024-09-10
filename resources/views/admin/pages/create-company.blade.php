@extends('admin.layouts.admin')
@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $data['title'] }}</h4>
                <form class="forms-sample" method="POST" action="{{ route('create.company') }}">
                    @csrf

                    @isset($data['company'])
                    <input type="hidden" name="id" id="id" value="{{ $data['company']->id }}">
                    @endisset
                    <div class="form-group ">
                        <label for="company_name">Company Name</label>
                        <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" placeholder="Company Name" value="{{ old('company_name',$data['company']->company_name ?? null) }}">
                        @error('company_name')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" placeholder="First Name" value="{{ old('first_name',$data['company']->first_name ?? null) }}">
                            @error('first_name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" placeholder="Last Name" value="{{  old('last_name',$data['company']->last_name ?? null) }}">
                            @error('last_name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="user_name">User Name</label>
                        <input type="text" class="form-control @error('user_name') is-invalid @enderror" id="user_name" name="user_name" placeholder="User Name" value="{{ old('user_name',$data['company']->user_name ?? null) }}">
                        @error('user_name')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email',$data['company']->email ?? null) }}">
                        @error('email')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                        @isset($data['company'])
                        <span class="fa-paragraph text-small" role="alert"> Note : If you wants to update the password just enter here other wise leave it blank</span>
                        @endisset
                    </div>

                    <div class="form-group">
                        <label for="company_type">Company Type</label>
                        <select name="company_type" id="company_type" class="form-control @error('company_type') is-invalid @enderror">
                            <option selected disabled>Select Company Type</option>
                            @foreach (config('job.company_types') as $type )
                            <option value="{{ $type }}" {{ $type == old('company_type',$data['company']->company_type ?? null) ?'selected':''  }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('company_type')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    @isset($data['company'])

                    <div class="form-group" id="status-wrap">
                        <label for="status">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active" {{ "active" === old('status',$data['company']->status ?? null) ?'selected':''  }}>Active</option>
                            <option value="deleted" {{ "deleted" === old('status',$data['company']->status ?? null) ?'selected':''  }}>Deleted</option>
                        </select>
                    </div>
                    @endisset
                    <button type="submit" class="btn btn-primary me-2"> @if(isset($data['company'])) Update @else Submit @endif</button>
                    <button class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

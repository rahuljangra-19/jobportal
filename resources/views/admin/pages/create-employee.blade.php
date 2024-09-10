@extends('admin.layouts.admin')
@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $data['title'] }}</h4>
                <form class="forms-sample" method="POST" action="{{ route('create.employee') }}">
                    @csrf

                    @isset($data['employee'])
                    <input type="hidden" name="id" id="id" value="{{ $data['employee']->id }}">
                    @endisset
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" placeholder="First Name" value="{{ old('first_name',$data['employee']->first_name ?? null) }}">
                            @error('first_name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" placeholder="Last Name" value="{{  old('last_name',$data['employee']->last_name ?? null) }}">
                            @error('last_name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="user_name">User Name</label>
                        <input type="text" class="form-control @error('user_name') is-invalid @enderror" id="user_name" name="user_name" placeholder="User Name" value="{{ old('user_name',$data['employee']->user_name ?? null) }}">
                        @error('user_name')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email',$data['employee']->email ?? null) }}">
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
                        @isset($data['employee'])
                        <span class="fa-paragraph text-small" role="alert"> Note : If you wants to update the password just enter here other wise leave it blank</span>
                        @endisset
                    </div>

                    
                    @isset($data['employee'])

                    <div class="form-group" id="status-wrap">
                        <label for="status">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active" {{ "active" === old('status',$data['employee']->status ?? null) ?'selected':''  }}>Active</option>
                            <option value="deleted" {{ "deleted" === old('status',$data['employee']->status ?? null) ?'selected':''  }}>Deleted</option>
                        </select>
                    </div>
                    @endisset
                    <button type="submit" class="btn btn-primary me-2"> @if(isset($data['employee'])) Update @else Submit @endif</button>
                    <button class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

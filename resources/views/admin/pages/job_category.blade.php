@extends('admin.layouts.admin')

@section('content')
    @inject('carbon', 'Carbon\Carbon')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Job Category Details Table</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add
                            new</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> ID </th>
                                    <th> Name </th>
                                    <th> Status </th>
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
                                        <td> {{ $value->name }} </td>
                                        <td>
                                            <div class="badge badge-{{ $value->status == 1 ? 'success' : 'danger' }}">
                                                {{ $value->status == 1 ? 'Active ' : 'Deleted' }}
                                            </div>
                                        </td>
                                        <td> {{ $carbon->parse($value->created_at)->format('d M , Y') }}</td>
                                        <td>
                                            <div class="d-flex justify-content-around">
                                                <a href="#" onclick="edit(`{{ $value->id }}`)"><i
                                                        class="fa fa-pencil"></i></a>
                                                <a href="{{ route('delete.category', ['id' => $value->id]) }}"
                                                    onclick="return confirm('Are you sure?')"><i
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
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Job Category</h5>
                    <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title" id="category_title">Create new category</h4>
                                    <form class="forms-sample" id="category-form" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" id="cat_id" value="">
                                        <div class="form-group">
                                            <label for="name">Category Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Category name">
                                        </div>
                                        <div class="form-group d-none" id="status-wrap">
                                            <label for="status">Status</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="1">Active</option>
                                                <option value="2">Delete</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                                        <button class="btn btn-light" type="button" data-bs-dismiss="modal">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(() => {
            let form = $('#category-form');
            form.submit((e) => {
                e.preventDefault();
                console.log('submit');
                $.ajax({
                    url: `{{ route('create.category') }}`,
                    method: 'POST',
                    data: form.serializeArray(),
                    success: (response) => {
                        if (response.status == 400) {
                            toastr.warning(response.message);
                        }
                        if (response.status == 200) {
                            toastr.success(response.message);
                            form.reset;
                            $('#exampleModal').modal('toggle');
                            $('#status-wrap').addClass('d-none');
                            $('#category_title').html(`Create new category`);
                            window.location.reload();
                        }
                    },
                    error: (error) => {
                        console.log('An error occurred:', error);
                    }
                });
            });

        });

        function edit(id) {
            $('#category_title').html(`Update category`);
            $.ajax({
                url: `{{ route('get.category') }}`,
                method: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response);
                    $('#status-wrap').removeClass('d-none');
                    $('#name').val(response.data.name);
                    $('#cat_id').val(response.data.id);
                    $('#exampleModal').modal('toggle');

                    const myElement = document.getElementById("status");
                    for (const child of myElement.children) {
                        if (child.value == response.data.status) {
                            child.selected = true;
                        }
                    }

                },
                error: function(err) {
                    console.log(err);
                }
            })
        }
    </script>
@endsection

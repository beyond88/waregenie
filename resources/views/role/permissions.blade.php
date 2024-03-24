@extends("layouts.layout")
@section("title", "Permissions | Waregenie")
@section("content")
    <div class="container-scroller">

        @include("layouts.top-bar")

        <div class="container-fluid page-body-wrapper">

            @include("layouts.sidebar")

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> Permissions </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Permissions</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    @if (session()->has('message') && session()->get('type') === 'success')
                                        <div class="alert alert-success">
                                            {{ session()->get('message') }}
                                        </div>
                                    @endif

                                    @if (session('error'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('permissions') }}" class="forms-sample">
                                        @csrf
                                        <div class="form-group">
                                            <label for="role">Role</label>
                                            <select name="role_id" id="role_id" class="form-control" onchange="loadPermissions(this.value)">
                                                <option value="">Select Role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group" style="display: flex; flex-direction: row; gap: 40px;">
                                            <fieldset>
                                                <legend>Inventory</legend>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[inventory][view]" value="view"> View <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[inventory][create]" value="create"> Create <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[inventory][edit]" value="edit"> Edit <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[inventory][delete]" value="delete"> Delete <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <legend>Order</legend>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[order][view]" value="view"> View <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[order][create]" value="create"> Create <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[order][edit]" value="edit"> Edit <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[order][delete]" value="delete"> Delete <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <legend>Receiving</legend>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[receiving][view]" value="view"> View <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[receiving][create]" value="create"> Create <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[receiving][edit]" value="edit"> Edit <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[receiving][delete]" value="delete"> Delete <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <legend>Picking and Packing</legend>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[receiving][view]" value="view"> View <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[receiving][create]" value="create"> Create <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[receiving][edit]" value="edit"> Edit <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[receiving][delete]" value="delete"> Delete <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <legend>Shipping</legend>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[shipping][view]" value="view"> View <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[shipping][create]" value="create"> Create <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[shipping][edit]" value="edit"> Edit <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[shipping][delete]" value="delete"> Delete <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <legend>Report</legend>
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[report][view]" value="view"> View <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[report][create]" value="create"> Create <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[report][edit]" value="edit"> Edit <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" class="form-check-input" name="permissions[report][delete]" value="delete"> Delete <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                                        <button class="btn btn-light" onclick="window.location.href='/permissions'">Cancel</button>
                                    </form>

                                    <script>
                                        function loadPermissions(roleId){
                                            if(roleId !==''){
                                                $.ajax({
                                                    url: "{{ route('permissions.load') }}",
                                                    type: "GET",
                                                    data: {
                                                        role_id: roleId,
                                                        _token: "{{ csrf_token() }}"
                                                    },
                                                    success: function(response){
                                                        try {
                                                            if( response.length > 0 ){
                                                                const permissionsData = JSON.parse(response);
                                                                if (typeof permissionsData === 'object' && permissionsData !== null) {
                                                                    $('.form-check-input').each(function() {
                                                                        $(this).prop('checked', false);
                                                                    });
                                                                    $.each(permissionsData, function(module, permissions) {
                                                                        if (typeof permissions === 'object' && permissions !== null) {
                                                                            $.each(permissions, function(index, permission) {
                                                                                let checkbox = $('[name="permissions[' + module + '][' + permission + ']"]');
                                                                                if (checkbox.length > 0) {
                                                                                    checkbox.prop('checked', true);
                                                                                } else {
                                                                                    console.warn('Checkbox not found for permission: ' + module + '.' + permissions);
                                                                                }
                                                                            });
                                                                        }
                                                                    });
                                                                } else {
                                                                    console.error('Unexpected response format:', response);
                                                                }
                                                            } else{
                                                                $('.form-check-input').each(function() {
                                                                    $(this).prop('checked', false);
                                                                });
                                                                alert('Permissions is not set yet!');
                                                            }
                                                        } catch (error) {
                                                            console.error('Error parsing JSON response:', error);
                                                        }
                                                    },
                                                    error: function(jqXHR, textStatus, errorThrown){
                                                        console.error("Error loading permissions:", textStatus, errorThrown);
                                                    }
                                                });
                                            }
                                        }
                                    </script>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
@endsection

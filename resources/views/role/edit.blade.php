<h1>Edit Role</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('role.update', $role->id) }}">
    @csrf  @method('PUT')
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $role->name) }}">
    </div>
    <br />

    <button type="submit" class="btn btn-primary">Update Role</button>
</form>

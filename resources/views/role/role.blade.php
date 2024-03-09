<h1>Roles</h1>

<table class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($roles as $role)
        <tr>
            <td>{{ $role->id }}</td>
            <td>{{ $role->name }}</td>
            <td>
                <a href="{{ url('role/' . $role->id . '/edit') }}" class="btn btn-primary btn-sm">Edit</a>
                <form method="POST" action="{{ route('role.destroy', $role->id) }}" onsubmit="return confirm('Are you sure you want to delete this role?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="2">No roles found!</td>
        </tr>
    @endforelse
    </tbody>
</table>
<br />

{{ $roles->links() }}

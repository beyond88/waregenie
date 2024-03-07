

@if (session()->has('message') && session()->get('type') === 'success')
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
<br />
<form method="POST" action="{{ route('role.create') }}">
    @csrf

    <input type="text" name="name" required placeholder="Name"><br><br>

    <textarea name="description" id="description" placeholder="Description"></textarea><br><br>

    <input type="submit" name="role" value="Create">

</form>

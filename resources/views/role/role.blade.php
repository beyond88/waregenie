
<form method="POST" action="{{ route('role') }}">
    @csrf

    <input type="text" name="name" required placeholder="Name"><br><br>

    <textarea name="description" id="description" placeholder="Description"></textarea><br><br>

    <input type="submit" name="role" value="Create">

</form>

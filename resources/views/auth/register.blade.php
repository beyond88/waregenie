
<form method="POST" action="{{ route('register') }}">
    @csrf

    <input type="text" name="name" required placeholder="Name"><br><br>

    <input type="email" name="email" required placeholder="Email"><br><br>

    <input type="password" name="password" required maxlength="10" placeholder="Password"><br><br>

    <input type="password" name="password_confirmation" required maxlength="10" placeholder="Confirm Password"><br><br>

    <input type="submit" name="register" value="Submit">

</form>

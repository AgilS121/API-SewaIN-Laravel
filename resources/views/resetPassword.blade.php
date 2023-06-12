@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $errors }}</li>
        @endforeach
    </ul>
@endif

<form method="POST">
    @csrf
    <input type="text" name="id" value="{{ $user[0]['id'] }}">
    <input type="password" name="password" placeholder="New Password">
    <br><br>
    <input type="password" name="password_confirmation" placeholder="Confirm New Password">
    <br><br>
    <input type="submit">
</form>

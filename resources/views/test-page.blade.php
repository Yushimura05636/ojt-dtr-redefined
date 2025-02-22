<form action="{{ route('auth.test') }}" method="post">
    @csrf
    @method('POST');
    <input type="text" name="client_privilege_access" value="admin">
    <input type="text" name="client_privilege" value="admin">
    <button type="submit">Test</button>
</form>
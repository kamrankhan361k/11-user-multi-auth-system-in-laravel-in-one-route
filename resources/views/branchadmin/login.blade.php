<h1>BranchAdmin Login</h1>

<form method="POST" action="{{ route('branchadmin.login') }}">
    @csrf
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

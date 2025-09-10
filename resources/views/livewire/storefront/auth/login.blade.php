<form wire:submit="login">
    <div class="form-group">
        <input type="text" wire:model="form.email" name="email" placeholder="Your Email"
            value="{{ old('email', 'test@example.com') }}">
        @error('form.email')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="form-group">
        <input type="password" wire:model="form.password" name="password" placeholder="Password">
        @error('form.password')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="login_footer form-group">
        <div class="chek-form">
            <div class="custome-checkbox">
                <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1"
                    wire:model="form.remember" />
                <label class="form-check-label" for="exampleCheckbox1">
                    <span>Remember me</span>
                </label>
            </div>
        </div>
        <a class="text-muted" href="{{ route('password.request') }}">Forgot password?</a>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-fill-out btn-block hover-up" name="login" wire:loading.attr="disabled"
            wire:target="login">
            Log in
        </button>
    </div>
</form>

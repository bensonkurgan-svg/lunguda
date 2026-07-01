<div class="mx-auto flex max-w-md flex-col px-4 py-16 md:py-24">
    <div class="card p-8">
        <p class="eyebrow">Join the archive</p>
        <h1 class="mt-2 font-display text-3xl font-semibold">Create an account</h1>
        <p class="mt-2 text-sm text-basalt/60">New accounts start as learners. An administrator can grant contributor access.</p>

        <form wire:submit="register" class="mt-6 space-y-4">
            <div>
                <label for="name" class="text-sm font-semibold">Full name</label>
                <input id="name" type="text" wire:model="name" class="field mt-1.5" autocomplete="name" autofocus>
                @error('name')<p class="mt-1 text-sm text-laterite">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="email" class="text-sm font-semibold">Email</label>
                <input id="email" type="email" wire:model="email" class="field mt-1.5" autocomplete="email">
                @error('email')<p class="mt-1 text-sm text-laterite">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password" class="text-sm font-semibold">Password</label>
                <input id="password" type="password" wire:model="password" class="field mt-1.5" autocomplete="new-password">
                @error('password')<p class="mt-1 text-sm text-laterite">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password_confirmation" class="text-sm font-semibold">Confirm password</label>
                <input id="password_confirmation" type="password" wire:model="password_confirmation" class="field mt-1.5" autocomplete="new-password">
            </div>
            <button type="submit" class="btn-primary w-full" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="register">Create account</span>
                <span wire:loading wire:target="register">Creating…</span>
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-basalt/60">
            Already have an account? <a href="{{ route('login') }}" wire:navigate class="font-semibold text-sorghum-600">Sign in</a>
        </p>
    </div>
</div>

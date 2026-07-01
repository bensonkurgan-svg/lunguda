<div class="mx-auto flex max-w-md flex-col px-4 py-16 md:py-24">
    <div class="card p-8">
        <p class="eyebrow">Welcome back</p>
        <h1 class="mt-2 font-display text-3xl font-semibold">Sign in</h1>
        <p class="mt-2 text-sm text-basalt/60">Access your account to contribute words, recordings and stories.</p>

        <form wire:submit="login" class="mt-6 space-y-4">
            <div>
                <label for="email" class="text-sm font-semibold">Email</label>
                <input id="email" type="email" wire:model="email" class="field mt-1.5" autocomplete="email" autofocus>
                @error('email')<p class="mt-1 text-sm text-laterite">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password" class="text-sm font-semibold">Password</label>
                <input id="password" type="password" wire:model="password" class="field mt-1.5" autocomplete="current-password">
                @error('password')<p class="mt-1 text-sm text-laterite">{{ $message }}</p>@enderror
            </div>
            <label class="flex items-center gap-2 text-sm text-basalt/70">
                <input type="checkbox" wire:model="remember" class="rounded border-basalt/20 text-sorghum focus:ring-sorghum">
                Keep me signed in
            </label>
            <button type="submit" class="btn-primary w-full" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="login">Sign in</span>
                <span wire:loading wire:target="login">Signing in…</span>
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-basalt/60">
            New here? <a href="{{ route('register') }}" wire:navigate class="font-semibold text-sorghum-600">Create an account</a>
        </p>
    </div>
</div>

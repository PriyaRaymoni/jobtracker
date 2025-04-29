<section class="w-full">
    <header>
        <h2 class="text-lg font-medium text-text">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-primary-dark">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="w-full flex flex-row gap-4 space-y-6"
        enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="flex flex-col gap-4 min-w-[30vw]">
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-text">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification"
                                class="underline text-sm text-primary hover:text-primary-dark rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button class="bg-blue-500 rounded-full">{{ __('Save') }}</x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-primary-dark">{{ __('Saved.') }}</p>
                @endif
            </div>
        </div>
        {{-- photo --}}
        <div class="flex flex-col gap-2 items-center justify-center ms-28">
            @if($user->profile_photo)
                <div class="rounded-full h-40 w-40 overflow-hidden text-center">
                    <img src="data:image/png;base64,{{ $user->profile_photo }}" alt="Profile Photo"
                        class=" object-cover bg-primary-light" />
                </div>
            @else
                <div class="bg-red-500 rounded-full h-40 w-40"></div>
            @endif
            <label class="px-4 py-1 rounded-2xl bg-blue-500 text-white cursor-pointer mt-2">
                {{ __('Change Image') }}
                <input type="file" name="profile_photo" accept="image/*" class="hidden" />
            </label>
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
        </div>
    </form>
</section>
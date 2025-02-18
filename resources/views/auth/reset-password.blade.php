<span>
    <x-modal.confirmation-update-password-modal id="confirmation-update-password-modal" />
</span>

<main class="container mx-auto max-w-screen-xl">
    <x-main-layout>
        @php
            $token = request()->query('token');
            $email = request()->query('email');
        @endphp
        <x-form.container routeName="reset-password-validation" method="POST" className="space-y-10 w-1/3">
            <x-logo />

            <div class="flex justify-center">
                <x-page-title title="reset password" />
            </div>

            <div class="space-y-5">
                <x-form.input label="New Password" name_id="password" type="password" big placeholder="••••••••" />
                <x-form.input label="Confirm Password" name_id="password_confirmation" type="password" big
                    placeholder="••••••••" />
                <x-form.input name_id="token" type="text" hidden
                    value="{{$token}}" />
                <x-form.input name_id="email" type="text" hidden
                    value="{{$email}}" />
                <div class="flex justify-end">
                    <x-button primary submit openModal="confirmation-update-password-modal" className="modal-button"
                        label="Update Password" />
                </div>
            </div>
        </x-form.container>
    </x-main-layout>
</main>

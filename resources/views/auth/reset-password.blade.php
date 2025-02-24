{{-- <span>
    <x-modal.confirmation-update-password-modal id="confirmation-update-password-modal" />
    
</span> --}}

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- jQuery (Required for Toastr) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<x-main-layout>
    <main class="container mx-auto max-w-screen-xl">
        @if (session('invalid'))
            <x-modal.flash-msg msg="invalid" />
        @else
            <x-modal.flash-msg msg="success" />
        @endif
        @php
            $token = request()->query('token');
            $email = request()->query('email');
        @endphp
        <div class="h-screen flex items-center justify-center w-full lg:!p-10 p-5">
            <x-form.container routeName="reset-password-validation" method="POST" className="flex flex-col gap-7 lg:!w-1/2 md:!w-1/2 w-full border shadow-lg p-7 rounded-lg">
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
                        <x-button primary submit
                            label="Update Password" />
                    </div>
                </div>
            </x-form.container>
        </div>
    </main>
</x-main-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div style="background-color: #fff7f7; padding-top: 1.4rem; padding-bottom: 1.4rem;">
        <div style="max-width: 64rem; margin-left: auto; margin-right: auto; padding-left: 1rem; padding-right: 1rem;">
            
            <div style="display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
                
                <div style="flex: 1; min-width: 280px; padding: 1.25rem; background-color: white; border: 1px solid #ef4444; border-radius: 0.375rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); font-size: 0.875rem;">
                    <div style="width: 100%;">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div style="flex: 1; min-width: 280px; padding: 1.25rem; background-color: white; border: 1px solid #ef4444; border-radius: 0.375rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); font-size: 0.875rem;">
                    <div style="width: 100%;">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div style="padding: 1.25rem; background-color: white; border: 1px solid #ef4444; border-radius: 0.375rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); font-size: 0.875rem; width: 100%;">
                <div style="width: 100%;">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
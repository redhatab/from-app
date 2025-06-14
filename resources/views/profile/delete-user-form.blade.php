<x-action-section>
    <x-slot name="title">
        {{ __('Удаление аккаунта') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Удалить свой аккаунт навсегда.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('После удаления вашей учетной записи все ее ресурсы и данные будут удалены без возможности восстановления. Прежде чем удалять свою учетную запись, выгрузите все данные или информацию, которую вы хотите сохранить.') }}
        </div>

        <div class="mt-5">
            <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                {{ __('Удалить аккаунт') }}
            </x-danger-button>
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-dialog-modal wire:model.live="confirmingUserDeletion">
            <x-slot name="title">
                {{ __('Удалить аккаунт') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Вы уверены, что хотите удалить свою учетную запись? После удаления вашей учетной записи все ее ресурсы и данные будут удалены без возможности восстановления. Пожалуйста, введите свой пароль, чтобы подтвердить, что вы хотите навсегда удалить свою учетную запись.') }}

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-input type="password" class="mt-1 block w-3/4"
                                autocomplete="current-password"
                                placeholder="{{ __('Password') }}"
                                x-ref="password"
                                wire:model="password"
                                wire:keydown.enter="deleteUser" />

                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    {{ __('Закрыть') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" wire:click="deleteUser" wire:loading.attr="disabled">
                    {{ __('Удалить аккаунт') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>

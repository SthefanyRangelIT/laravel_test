<div class="justify-center">
    <div class="flex flex-row">
        <div class="flex flex-col w-full">
            <x-jet-button class="btn-primary mx-auto px-2 justify-start" wire:click="openRegisterModal">
                {{ __('Register new Book') }}
            </x-jet-button>
        </div>
    </div>

    <div class="flex flex-row" wire:model="register_modal">
        <div class="flex flex-col w-full">
            <table id="dt_books" class="table-auto border-collapse">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Author</th>
                        <th>Publication date</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                @forelse ($books as $book)
                <tbody>
                    <tr>
                        <td>{{ $book->name }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->publication_date }}</td>
                        <td>{{ $book->category_name }}</td>
                        <td>
                            @if ($book->borrowed == false)
                                <span class="text-xs px-2 font-medium bg-green-700 text-black rounded-full py-0.5">
                                    Available
                                </span>
                            @else
                                <span class="text-xs px-2 font-medium bg-red-700 text-white rounded py-0.5">
                                    Borrowed
                                </span>
                            @endif
                        </td>
                        <td>
                            <x-jet-button wire:click="openEditModal({{ $book->book_id }})">Edit</x-jet-button>
                            <x-jet-button wire:click="openDeleteModal({{ $book->book_id }})">Delete</x-jet-button>
                            @if ($book->borrowed == false)
                                <x-jet-button wire:click="openBorrowModal({{ $book->book_id }})">Lend it</x-jet-button>
                            @else
                                <x-jet-button wire:click="openBorrowModal({{ $book->book_id }})">Change status</x-jet-button>
                            @endif
                        </td>
                    </tr>
                </tbody>
                @empty
                <tr>
                    <td colspan="4">{{ 'No data available' }}</td>
                </tr>
                @endforelse
            </table>
        </div>
    </div>

    {{-- register book --}}
    <x-jet-dialog-modal wire:model="register_modal">
        <x-slot name="title">
            {{ __('Register Book') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-input type="text" class="mt-1 block w-3/4" placeholder="{{ __('Book Title') }}" wire:model.defer="name" />
                <x-jet-input-error for="name" class="mt-2" />

                <x-jet-input type="text" class="mt-1 block w-3/4" placeholder="{{ __('Author') }}" wire:model.defer="author" />
                <x-jet-input-error for="author" class="mt-4" />

                <x-jet-label for="publication_date" class="mt-2 ml-2">Publication date</x-jet-label>
                <x-jet-input type="date" class="mt-1 block w-3/4" placeholder="{{ __('Publication date') }}" wire:model.defer="publication_date" />
                <x-jet-input-error for="publication_date" class="mt-2" />

                <x-jet-label for="category_id" class="w-1/3" value="{{ __('Category: ') }}" />
                <select name="category_id" id="category_id" class="mt-1 block w-full" wire:model.defer="category_id">
                    <option selected value="none">--- choose an option ---</option>
                    @forelse ($categories as $category)
                        <option value="{{ $category['category_id'] }}">{{ $category['category_name'] }}</option>
                    @empty
                        <option value="">{{ __('No categories available') }}</option>
                    @endforelse
                </select>
                <x-jet-input-error for="category_id" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('register_modal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="registerBook" wire:loading.attr="disabled" wire:keydown.enter="registerBook">
                {{ __('Register') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

    {{-- edit book --}}
    <x-jet-dialog-modal wire:model="edit_modal">
        <x-slot name="title">
            {{ __('Edit book information') }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-jet-input type="text" class="mt-1 block w-3/4" placeholder="{{ __('Book Title') }}" wire:model.defer="name" />
                <x-jet-input-error for="name" class="mt-2" />

                <x-jet-input type="text" class="mt-1 block w-3/4" placeholder="{{ __('Author') }}" wire:model.defer="author" />
                <x-jet-input-error for="author" class="mt-4" />

                <x-jet-label for="publication_date" class="mt-2 ml-2">Publication date</x-jet-label>
                <x-jet-input type="date" class="mt-1 block w-3/4" placeholder="{{ __('Publication date') }}" wire:model.defer="publication_date" />
                <x-jet-input-error for="publication_date" class="mt-2" />

                <x-jet-label for="category_id" class="w-1/3" value="{{ __('Category: ') }}" />
                <select name="category_id" id="category_id" class="mt-1 block w-full" wire:model.defer="category_id">
                    <option selected value="none">--- choose an option ---</option>
                    @forelse ($categories as $category)
                        <option value="{{ $category['category_id'] }}">{{ $category['category_name'] }}</option>
                    @empty
                        <option value="">{{ __('No categories available') }}</option>
                    @endforelse
                </select>
                <x-jet-input-error for="category_id" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('edit_modal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="editBook" wire:loading.attr="disabled" wire:keydown.enter="editBook">
                {{ __('Save') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

    {{-- delete book --}}
    <x-jet-dialog-modal wire:model="delete_modal">
        <x-slot name="title">
            {{ __('Delete Book') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete the following book?')}}
            <div class="mt-4">
                <x-jet-label for="category_id" class="w-1/3">Title: {{ $name }}</x-jet-label>
                <x-jet-label for="category_id" class="w-1/3">Author: {{ $author }}</x-jet-label>
                <x-jet-label for="category_id" class="w-1/3">Publication_date: {{ $publication_date }}</x-jet-label>
                <x-jet-label for="category_id" class="w-1/3">Category: {{ $category_name }}</x-jet-label>

            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('delete_modal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteBook" wire:loading.attr="disabled">
                {{ __('Yes, delete it') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

    {{-- borrow book --}}
    <x-jet-dialog-modal wire:model="borrow_modal">
        <x-slot name="title">
            {{ __('Change Book Status') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to change the status of the following book?')}}
            <div class="mt-4">
                <x-jet-label class="w-1/3">Title: {{ $name }}</x-jet-label>
                <x-jet-label class="w-1/3">Author: {{ $author }}</x-jet-label>
                <x-jet-label class="w-1/3">Publication_date: {{ $publication_date }}</x-jet-label>
                <x-jet-label class="w-1/3">Category: {{ $category_name }}</x-jet-label>
                <x-jet-label class="w-1/3">Select user</x-jet-label>
                @if ($borrowed == false)
                    <select name="user_id" id="user_id" class="mt-1 block w-full" wire:model.defer="user_id">
                        <option selected value="none">--- choose an option ---</option>
                        @forelse ($users as $user)
                            <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                        @empty
                            <option value="">{{ __('No users available') }}</option>
                        @endforelse
                    </select>
                @endif
                <x-jet-input-error for="user_id" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('borrow_modal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="changeBookStatus" wire:loading.attr="disabled" wire:keydown.enter="changeBookStatus">
                @if ($borrowed == false)
                    {{ __('Yes, lend it')}}
                @else
                    {{ __('Return book')}}
                @endif
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-confirmation-modal wire:model="confirmation_modal">
        <x-slot name="title">
            {{ $confirmation_message }}
        </x-slot>

        <x-slot name="content">

        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmation_modal')" wire:loading.attr="disabled">
                {{ __('Ok, close message') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-confirmation-modal>

</div>

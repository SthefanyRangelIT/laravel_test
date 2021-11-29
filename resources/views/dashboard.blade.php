<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <livewire:dt-books />

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#dt_books').DataTable({
                    columnDefs: [
                        { orderable: false, targets: 5 }
                    ]
                });
            } );
        </script>
    @endpush
</x-app-layout>

<x-layout-app title="User profile">
    <div class="w-100 p-4">
        <h3>User Profile</h3>

        <hr>

        <div class="d-flex gap-5">
            <div>
                <i class="fa-solid fa-user me-3">
                    {{ auth()->user()->name }}
                </i>
            </div>

            <div>
                <i class="fa-solid fa-user me-3">
                    {{ auth()->user()->role }}
                </i>
            </div>

            <div>
                <i class="fa-solid fa-at me-3">
                    {{ auth()->user()->email }}
                </i>
            </div>

            <div>
                <i class="fa-solid fa-calendar-days me-3">
                    {{ auth()->user()->created_at->format('d/m/Y') }}
                </i>
            </div>

        </div>

        <hr>

    </div>
</x-layout-app>

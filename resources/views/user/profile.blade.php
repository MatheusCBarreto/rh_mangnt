<x-layout-app title="User profile">
    <div class="w-100 p-4">
        <h3>User Profile</h3>

        <hr>

        <x-profile-user-data />

        <hr>

        <div class="container-fluid m-0 p-0 mt-5">
            <div class="row">
                {{-- componente senha e confirmação de senha --}}
                <x-profile-user-change-password />

                {{-- componente name - email --}}
                <x-profile-user-change-data />

                {{-- componente endereço --}}
                <x-profile-user-change-address />

            </div>
        </div>

    </div>
</x-layout-app>

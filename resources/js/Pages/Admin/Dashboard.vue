<template>
    <div>
        <!-- Page title -->
        <h1 class="mb-8 text-2xl font-semibold text-gray-700">
            Dashboard
        </h1>

        <!-- Page content -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <div class="mt-8 text-2xl">
                    Admin dashboard
                </div>

                <div class="mt-6 text-gray-600">
                    This is the main hub of activity for administrators to which they get redirected after authentication
                    and from which they can navigate to other parts of the app.
                </div>

                <div class="mt-6 text-gray-600">
                    The <b>users module</b> can be accessed via sidebar navigation by clicking on
                    "Users" on the left side of the screen or via this
                    <inertia-link class="text-blue-700 underline" :href="route('users')">
                        link.
                    </inertia-link>
                    There you can do most of the user-related tasks like viewing all
                    registered users, creating new ones, editing already existing ones or even deleting them.
                </div>

                <div class="mt-6 text-gray-600">
                    However, there are some rules that have to be understood:
                    <br>
                    - You can only create and delete users that are lower in the role hierarchy than yourself.
                    <br>
                    - You cannot edit personal user information.
                    <br>
                    - You can edit user roles only if their current role and new role is
                    lower in the role hierarchy than your own.
                    <br>
                    - You cannot delete yourself. This has to be done from profile module to avoid mistakes.
                </div>

                <div class="mt-6 mb-8 text-gray-600">
                    Likewise also the <b>notes module</b> can be accessed via sidebar navigation by clicking on "Notes" or via this.
                    <inertia-link class="text-blue-700 underline" :href="route('users')">
                        link
                    </inertia-link>
                    There you can view all the notes used in exercises as well as change their audio files.
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AdminLayout from './../../Layouts/AdminLayout'

    export default {
        layout: AdminLayout,
    }
</script>

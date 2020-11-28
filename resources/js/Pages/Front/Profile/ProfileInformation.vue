<template>
    <form-section @submitted="updateProfileInformation">
        <template #title>
            Profile Information
        </template>

        <template #description>
            Update your account's profile information and email address.
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div class="col-span-6 sm:col-span-4">
                <image-input v-model="form.avatar" type="file" accept="image/*" label="Photo" />
            </div>

            <!-- Name -->
            <text-input v-model="form.full_name" :error="form.error('full_name')" label="Full Name" placeholder="Jane Doe" />

            <!-- Email -->
            <text-input v-model="form.email" :error="form.error('email')" label="Email" placeholder="jane.doe@example.com" />

        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <primary-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </primary-button>
        </template>
    </form-section>
</template>

<script>
    import PrimaryButton from './../../Shared/PrimaryButton'
    import FormSection from './../../Shared/FormSection'
    import JetInput from './../../Jetstream/Input'
    import JetInputError from './../../Jetstream/InputError'
    import JetLabel from './../../Jetstream/Label'
    import JetActionMessage from './../../Jetstream/ActionMessage'
    import JetSecondaryButton from './../../Jetstream/SecondaryButton'
    import TextInput from "../../Shared/TextInput"
    import ImageInput from "../../Shared/ImageInput"

    export default {
        components: {
            JetActionMessage,
            PrimaryButton,
            FormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
            TextInput,
            ImageInput,
        },

        data() {
            return {
                form: this.$inertia.form({
                    '_method': 'PUT',
                    full_name: this.$page.user.full_name,
                    email: this.$page.user.email,
                    avatar: new File(
                        [this.$page.avatar],
                        this.$page.avatar.split('\\').pop().split('/').pop()
                    ),
                }, {
                    bag: 'updateProfileInformation',
                    resetOnSuccess: false,
                }),

                photoPreview: null,
            }
        },

        methods: {
            updateProfileInformation() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0]
                }

                this.form.post(route('user-profile-information.update'), {
                    preserveScroll: true
                });
            },

            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(this.$refs.photo.files[0]);
            },

            deletePhoto() {
                this.$inertia.delete(route('current-user-photo.destroy'), {
                    preserveScroll: true,
                }).then(() => {
                    this.photoPreview = null
                });
            },
        },
    }
</script>

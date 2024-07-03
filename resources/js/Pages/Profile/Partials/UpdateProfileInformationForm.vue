<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Link, useForm, usePage} from '@inertiajs/vue3';
import {ArrowUpTrayIcon} from '@heroicons/vue/24/solid'
import {ref} from "vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import SkillManager from "@/Components/ITinder/Skills/SkillManager.vue";

defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
    availableUserSkills: Array<{ id: number, name: string }>;
    availableSeekingSkills: Array<{ id: number, name: string }>;
}>();

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    profile_picture: user.profile_picture,
    bio: user.bio ?? '',
    location: user.location ?? '',
    experience: user.experience ?? '',
    github_link: user.github_link ?? '',
    skills: user.skills ?? [],
    seeking_skills: user.seekingSkills ?? [],
});

const previewUrl = ref('');

const uploadImage = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewUrl.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Profile Information</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
            {{ user }}
            <div class="group w-fit">
                <InputLabel for="profile_picture" value="Avatar"/>
                <div class="relative h-40 w-40  flex justify-center items-center text-gray-300">
                    <ArrowUpTrayIcon class="z-10 opacity-0 absolute group-hover:opacity-100 w-10 h-10"/>
                    <input class="absolute z-10 inset-0 opacity-0 cursor-pointer" id="profile_picture"
                           type="file" @input="uploadImage($event)"/>
                    <img
                        class="rounded w-full h-full object-cover group-hover:bg-gray-800"
                        :src="previewUrl || form.profile_picture || '/images/default-avatar.jpg'"
                        alt="">
                    <div class="absolute inset-0 group-hover:bg-black/30 transition-all"></div>
                </div>
            </div>
            <div>
                <InputLabel for="name" value="Name"/>

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name"/>
            </div>

            <div>
                <InputLabel for="email" value="Email"/>

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email"/>
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600 dark:text-green-400"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div>
                <InputLabel for="bio" value="About"/>
                <TextAreaInput v-model="form.bio" placeholder="Enter some information about yourself"/>
                <InputError class="mt-2" :message="form.errors.bio"/>
            </div>

            <div>
                <InputLabel for="location" value="Location"/>
                <TextInput
                    id="location"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.location"
                    autocomplete="address-line1"
                />
                <InputError class="mt-2" :message="form.errors.location"/>
            </div>

            <div>
                <InputLabel for="experience" value="Experience"/>
                <TextAreaInput v-model="form.experience"
                               placeholder="Enter some information about your experience"/>
                <InputError class="mt-2" :message="form.errors.experience"/>
            </div>

            <div>
                <InputLabel for="github_link" value="Github Link"/>
                <TextInput
                    id="github_link"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.github_link"
                    autocomplete="url"
                />
                <InputError class="mt-2" :message="form.errors.github_link"/>
            </div>
            <div>
                <SkillManager v-model="form.skills" :available-skills="availableUserSkills" label="Your Skills"/>
                <InputError class="mt-2" :message="form.errors.skills"/>
            </div>

            <div>
                <SkillManager v-model="form.seeking_skills" :available-skills="availableSeekingSkills" label="Seeking Skills"/>
                <InputError class="mt-2" :message="form.errors.seeking_skills"/>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>

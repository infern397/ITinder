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
import {SkillInterface, UserInterface} from "@/types/UserInterface";

const strings = ref(usePage().props.strings);

defineProps<{
    mustVerifyEmail?: Boolean;
    status?: String;
    availableUserSkills: Array<{ id: number, name: string }>;
    availableSeekingSkills: Array<{ id: number, name: string }>;
}>();

const user: UserInterface = usePage().props.auth.user;

const originalProfilePicture = ref(user.profile_picture);

const previewUrl = ref('');
const userSkills = ref(user.skills ?? []);
const seekingSkills = ref(user.seeking_skills ?? []);

const form = useForm({
    name: user.name,
    email: user.email,
    profile_picture: user.profile_picture as string | File,
    bio: user.bio ?? '',
    location: user.location ?? '',
    experience: user.experience ?? '',
    github_link: user.github_link ?? '',
    skills: userSkills.value.map(skill => skill.id),
    seeking_skills: seekingSkills.value.map((skill: SkillInterface ) => skill.id),
});

const uploadImage = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target && target.files && target.files.length > 0) {
        const file = target.files[0];
        const reader = new FileReader();
        reader.onload = (e: ProgressEvent<FileReader>) => {
            if (e.target && typeof e.target.result === 'string') {
                previewUrl.value = e.target.result;
            }
        };
        reader.readAsDataURL(file);
        form.profile_picture = file;
    }
};

const submitForm = () => {
    if (originalProfilePicture.value === form.profile_picture) {
        delete form.profile_picture;
    }
    form.skills = userSkills.value.map(skill => skill.id);
    form.seeking_skills = seekingSkills.value.map((skill: SkillInterface ) => skill.id);
    form.post(route('profile.update'), {
        errorBag: 'updateProfileInformation',
        preserveScroll: true,
        onSuccess: () => {
            originalProfilePicture.value = user.profile_picture;
            // previewUrl.value = '';
        },
    });
};

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ strings['profile']['profile-info'] }}</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ strings['profile']['description-info'] }}
            </p>
        </header>
        <form @submit.prevent="submitForm" class="mt-6 space-y-6">
            <div class="group w-fit">
                <InputLabel for="profile_picture" :value="strings['profile']['avatar']"/>
                <div class="relative h-40 w-40  flex justify-center items-center text-gray-300">
                    <ArrowUpTrayIcon class="z-10 opacity-0 absolute group-hover:opacity-100 w-10 h-10"/>
                    <input class="absolute z-10 inset-0 opacity-0 cursor-pointer" id="profile_picture"
                           type="file" @input="uploadImage($event)"/>
                    <img
                        class="rounded w-full h-full object-cover group-hover:bg-gray-800"
                        :src="previewUrl || originalProfilePicture || '/images/default-avatar.jpg'"
                        alt="">
                    <div class="absolute inset-0 group-hover:bg-black/30 transition-all"></div>
                </div>
            </div>
            <div>
                <InputLabel for="name" :value="strings['profile']['name']"/>

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
                <InputLabel for="email" :value="strings['profile']['email']"/>

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
                <InputLabel for="bio" :value="strings['profile']['about']"/>
                <TextAreaInput v-model="form.bio" :placeholder="strings['profile']['about-placeholder']"/>
                <InputError class="mt-2" :message="form.errors.bio"/>
            </div>

            <div>
                <InputLabel for="location" :value="strings['profile']['location']"/>
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
                <InputLabel for="experience" :value="strings['profile']['experience']"/>
                <TextAreaInput v-model="form.experience"
                               :placeholder="strings['profile']['experience-placeholder']"/>
                <InputError class="mt-2" :message="form.errors.experience"/>
            </div>

            <div>
                <InputLabel for="github_link" :value="strings['profile']['github-link']"/>
                <TextInput
                    id="github_link"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.github_link"
                    autocomplete="url"
                />
                <InputError class="mt-2" :message="form.errors.github_link"/>
            </div>
            <div class="text-white">
                <SkillManager :placeholder="strings['profile']['your-skills-placeholder']" v-model="userSkills" :available-skills="availableUserSkills" :label="strings['profile']['your-skills']"/>
                <InputError class="mt-2" :message="form.errors.skills"/>
            </div>

            <div>
                <SkillManager :placeholder="strings['profile']['seeking-skills-placeholder']" v-model="seekingSkills" :available-skills="availableSeekingSkills"
                              :label="strings['profile']['seeking-skills']"/>
                <InputError class="mt-2" :message="form.errors.seeking_skills"/>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">{{ strings['profile']['save'] }}</PrimaryButton>

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

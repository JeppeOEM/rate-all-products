<script setup>
import { computed } from 'vue';
import PrimaryButton from '@/Components/Buttons/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post('email/verification-notification');
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
        <Head title="Email Verification" />
<div class="flex items-center justify-center ">

        <div class="flex flex-col p-8 rounded-lg border m-8">
        <div class="mb-4 text-m text-gray-600">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link
            we just emailed to you? If you didn't receive the email, we will gladly send you another.
        </div>

        <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent">
            A new verification link has been sent to the email address you provided during registration.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Resend Verification Email
                </PrimaryButton>

            </div>
        </form>
</div>

</div>
</template>

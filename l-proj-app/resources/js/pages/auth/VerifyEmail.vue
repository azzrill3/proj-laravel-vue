<script setup lang="ts">
import EmailVerificationNotificationController from '@/actions/App/Http/Controllers/Auth/EmailVerificationNotificationController';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { logout } from '@/routes';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
}>();
</script>

<template>
    <AuthLayout title="Подтвердить адрес электронной почты" description="Пожалуйста, подтвердите свой адрес электронной почты, перейдя по ссылке, которую мы только что отправили вам по электронной почте.">
        <Head title="Email verification" />

        <div v-if="status === 'verification-link-sent'" class="mb-4 text-center text-sm font-medium text-green-600">
            Новая ссылка для подтверждения была отправлена ​​на адрес электронной почты, указанный вами при регистрации.
        </div>

        <Form v-bind="EmailVerificationNotificationController.store.form()" class="space-y-6 text-center" v-slot="{ processing }">
            <Button :disabled="processing" variant="secondary">
                <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
                Повторно отправить письмо с подтверждением
            </Button>

            <TextLink :href="logout()" as="button" class="mx-auto block text-sm"> Выйти </TextLink>
        </Form>
    </AuthLayout>
</template>

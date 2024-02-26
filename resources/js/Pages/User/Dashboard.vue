<template>
    <AppLayout title="Dashboard">
        <Fieldset legend="Sistemas">
            <div class="flex flex-wrap justify-center sm:justify-start">
                <CardLink></CardLink>
                <CardLink></CardLink>
                <CardLink></CardLink>
                <CardLink></CardLink>
                <CardLink></CardLink>
            </div>
        </Fieldset>
    </AppLayout>
</template>
<script setup>
import CardLink from '@/Components/Card/CardLink.vue';
</script>

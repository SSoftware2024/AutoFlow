<template>
    <AppLayout title="Dashboard" title_page="Dashboard - Auto Escola">
        <div>
            <Fieldset legend="Agendamentos">
                <FullCalendar :options="calendarOptions" />
            </Fieldset>
        </div>
        <div class="mt-5">
            <Fieldset legend="Sua rede">
                <CardCount></CardCount>
            </Fieldset>
        </div>
    </AppLayout>
</template>
<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

//components
import CardCount from '@/Components/Card/CardCount.vue';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction';
import ptbrLocale from '@fullcalendar/core/locales/pt-br';
//fim components

const calendarOptions = ref({
    plugins: [dayGridPlugin,timeGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    height: 650,
    locales: [ptbrLocale],
    locale: 'pt-br',
    headerToolbar: {
        left: 'prev,next,today',
        center: 'title',
        // right: 'timeGridDay,timeGridWeek,dayGridMonth,dayGridYear'
        right: 'dayGridDay,timeGridDay,timeGridWeek,dayGridWeek,dayGridMonth,dayGridYear' // user can switch between the two
    }
});

const page = usePage();
</script>

<template>
    <AppLayout title="Dashboard" title_page="Dashboard - Auto Escola">
        <div>
            <Fieldset legend="Agendamentos" :toggleable="true">
                <FullCalendar :options="calendarOptions" />
            </Fieldset>
        </div>
        <div class="mt-5">
            <Fieldset legend="Aulas Hoje">
                <div class="flex justify-center flex-col flex-wrap items-center
                sm:justify-start sm:flex-row">
                    <CardCount icon="fa-solid fa-calendar-days" title="AGENDADAS" :count="10"
                    class="bg-success-500 text-white dark:bg-success-500"></CardCount>
                    <CardCount icon="fa-solid fa-calendar-check" title="EM EXECUÇÃO" :count="10"
                    class="bg-info-500 text-white dark:bg-info-500"></CardCount>
                    <CardCount icon="fa-solid fa-calendar-xmark" title="PERDIDAS" :count="10"
                    class="bg-danger-500 text-white dark:bg-danger-500"></CardCount>
                    <CardCount icon="fa-solid fa-file-pdf" title="RELÁTORIO" count=""
                    class="cursor-pointer hover:bg-red-600 hover:text-white dark:hover:bg-red-600"></CardCount>
                </div>
            </Fieldset>
        </div>
        <div class="mt-5">
            <Fieldset legend="Sua rede">
                <div class="flex justify-center flex-col flex-wrap items-center
                sm:justify-start sm:flex-row">
                    <CardCount icon="fa-solid fa-user" title="PROFESSORES" :count="page.props.counts.teachers" :link="true" :url="route('user.driving_school.teacher.index')"></CardCount>
                    <CardCount icon="fa-solid fa-users" title="ALUNOS" :count="page.props.counts.students" :link="true" :url="route('user.driving_school.students.index')"></CardCount>
                    <CardCount icon="fa-solid fa-car" title="VEÍCULOS" :count="page.props.counts.vehicles" :link="true" :url="route('user.driving_school.vehicles.index')"></CardCount>
                    <CardCount icon="fa-solid fa-user" title="BALCONISTA" :count="10"></CardCount>
                </div>
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
const page = usePage();

const calendarOptions = ref({
    plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    height: 650,
    locales: [ptbrLocale],
    locale: 'pt-br',
    headerToolbar: {
        left: 'prev,next,today',
        center: 'title',
        // right: 'timeGridDay,timeGridWeek,dayGridMonth,dayGridYear'
        right: 'dayGridDay,timeGridDay,timeGridWeek,dayGridWeek,dayGridMonth,dayGridYear' // user can switch between the two
    },
});
</script>

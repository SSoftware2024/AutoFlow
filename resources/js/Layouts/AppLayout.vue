<template>
    <Head :title="title" />
    <Banner />
    <!-- Primevue -->
    <Toast />
    <ConfirmDialog></ConfirmDialog>
    <div class="relative min-h-screen bg-gray-100 dark:bg-zinc-800">
        <sidebar :links="links" :isOpen="sidebar_isOpen" @click:close="closeSidebar"></sidebar>
        <navbar icon="fa-solid fa-bars" @click:icon="openSidebar">
            <span ref="theme" @click="changeTheme">
                <i class="fa-solid fa-moon"></i>
            </span>
            <icon-button-dropdown id="dropdownMenuButton1">
                <template #icon>
                    <i class="fa-solid fa-bell"></i>
                </template>
                <div class="p-4">
                    Content here
                </div>
            </icon-button-dropdown>

            <icon-button-dropdown id="dropdownMenuButton2">
                <template #icon>
                    <i class="fa-solid fa-gear"></i>
                </template>
                <link-dropdown title="Escuro/Claro"></link-dropdown>
                <link-dropdown title="Escuro/Claro"></link-dropdown>
                <link-dropdown title="Escuro/Claro"></link-dropdown>
                <link-dropdown title="Escuro/Claro"></link-dropdown>
            </icon-button-dropdown>
            <icon-button-dropdown id="dropdownMenuButton3">
                <template #icon>
                    <!-- :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name" -->
                    <img class="w-[40px] rounded-full border border-purple-600"
                        v-if="$page.props.jetstream.managesProfilePhotos && $page.props.auth.user.profile_photo_path"
                        :src="`/storage/${$page.props.auth.user.profile_photo_path}`" />
                    <img class="w-[40px] rounded-full border border-purple-600"
                        src="../../../public/img/profile-default.png" v-else />
                </template>
                <link-dropdown title="Perfil" :href="route('profile.show')"></link-dropdown>
                <form @submit.prevent="logout">
                    <button type="submit"
                        class="block w-full px-8 py-2 text-sm font-normal bg-transparent whitespace-nowrap text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600">
                        Sair
                    </button>
                </form>
            </icon-button-dropdown>
        </navbar>
        <div class="mt-2 custom-container">
            <div class="px-2 py-2 rounded-md bg-gradient-to-r from-slate-700 to-zinc-800 dark:bg-none dark:p-0"
                v-if="page.props.breadcrumb_show ?? false">
                <Breadcrumb :home="breadcrumb.home" :model="breadcrumb.items">
                    <template #item="{ item, props }">
                        <Link :href="item.route" v-if="item.route" v-bind="props.action">
                        <span :class="[item.icon, 'text-color']" />
                        <span class="font-semibold text-primary">{{ item.label }}</span>
                        </Link>
                        <a v-else :href="item.url" :target="item.target" v-bind="props.action">
                            <span class="text-color">{{ item.label }}</span>
                        </a>
                    </template>
                </Breadcrumb>
            </div>
            <div class="flex mt-2">
                <div class="flex px-3 py-2 bg-white border rounded-md dark:bg-zinc-600">
                    <i class="text-3xl text-blue-500 fa-solid fa-info"></i>
                    <h1 class="ml-2 text-3xl">{{ title_page ?? title }}</h1>
                </div>
            </div>
        </div>
        <div class="relative custom-container">

            <div class="box-border relative px-3 py-2 my-2 bg-white border rounded-md shadow-4 dark:bg-zinc-600"
                v-if="!$slots.center">
                <slot></slot>
            </div>
            <div class="box-border relative flex justify-center px-3 py-2 my-2 bg-white border rounded-md shadow-4 dark:bg-zinc-600"
                v-if="$slots.center">
                <div class="w-full xl:w-[80%] 2xl:w-[70%]">
                    <slot name="center"></slot>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import Banner from '@/Components/Banner.vue';
import Navbar from "@/Components/Navigate/NavBar.vue";
import Sidebar from "@/Components/Navigate/Sidebar.vue";
import IconButtonDropdown from "@/Components/DropDown/IconButton.vue";
import LinkDropdown from "@/Components/DropDown/Link.vue";
import SidebarGuard from '../Src/SidebarGuards.js';
const page = usePage();
const toast = useToast();
const links = ref(SidebarGuard.generateForGuard(page.props.auth_more.guard));
const sidebar_isOpen = ref(false);

let breadcrumb = ref(null);
try {
    breadcrumb = ref(page.props.breadcrumb_show ? {
        home: {
            icon: page.props.breadcrumb.home.icon ?? '',
            route: page.props.breadcrumb.home.route ?? ''
        },
        items: page.props.breadcrumb.items ?? '',
    } : {});
} catch (error) {
    console.log("%cBreadcrumb obrigatório nesta página", "color: red; font-size: 18px; font-weight: bold; background-color: white; text-shadow: white .4px .4px");
    console.error("Necessário informar breadcrumb no back-end a página exige. Ou coloque pagina na lista de 'routes_excpet' do breadcrumb", error);
}

defineProps({
    title: String,
    title_page: String,
});

//ref attr, reference
const theme = ref(null);
//functions
function _startTheme() {
    theme.value.innerHTML = (
        localStorage.getItem('theme') && localStorage.getItem('theme') == 'dark'
    ) ? '<i class="fa-solid fa-sun"></i>' : '<i class="fa-solid fa-moon"></i>';

}
function changeTheme() {
    if (document.documentElement.classList.contains('dark')) {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
        theme.value.innerHTML = '<i class="fa-solid fa-moon"></i>';
    } else {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
        theme.value.innerHTML = '<i class="fa-solid fa-sun"></i>';
    }
    window.location.reload();
}
function openSidebar() {
    sidebar_isOpen.value = true;
}
const closeSidebar = () => {
    sidebar_isOpen.value = false;
}
const logout = () => {
    router.post(route('logout'));
};

function _flash_toast(queque_toast) {
    if (queque_toast) {
        // console.log(queque_toast.length);
        queque_toast.forEach(element => {
            toast.add({ severity: element.type, summary: element.title, detail: element.message, life: page.props.toast.time });
        });
    }
}


onMounted(() => {
    _startTheme();
})
onUnmounted(
    router.on('success', (event) => {
        _flash_toast(event.detail.page.props.flash.flash_toast);
    })
)
onUnmounted(
    router.on('error', (event) => {
        let errors = event.detail.errors;
        errors.catch ?
            toast.add({ severity: 'error', summary: 'Erro', detail: errors.catch })
            :
            null;
    })
)

</script>
<style scoped>
.p-breadcrumb {
    padding: 10px;
}

.p-menuitem-text.dark {
    color: white;
}
</style>

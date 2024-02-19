<template>
    <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-col sm:flex-row sm:justify-between"
        v-if="pagination.last_page > 1">
        <div>
            <p class="text-sm leading-5 text-gray-700 dark:bg-gray-400">
                Mostrando
                <span v-if="pagination.total > 0">
                    {{ (pagination.per_page * (pagination.current_page - 1)) + 1 }}
                </span>
                até
                <span>{{ (pagination.per_page * pagination.current_page) > pagination.total ? pagination.total :
                    (pagination.per_page * pagination.current_page) }}</span>
                de
                <span>{{ pagination.total }}</span>
                resultados
            </p>
        </div>
        <div class="flex">
            <button v-if="pagination.current_page === 1" class="pagination-button-disabled" disabled>
                Anterior
            </button>
            <button v-else @click="paginate(pagination.current_page - 1)" class="underline hover:font-bold">
                Anterior
            </button>
            <div class="flex">
                <div>
                    <span class="relative z-0 inline-flex mt-1 rounded-md shadow-sm rtl:flex-row-reverse">
                        <button v-for="(page, key, index) in pagination.last_page" :key="page" @click="paginate(page)">
                            <span v-if="pageShow(page, pagination.current_page, pagination.last_page)"
                                :class="{ 'pagination-button': page !== pagination.current_page, 'pagination-button-active': page === pagination.current_page }">{{
                                    page }}</span>
                        </button>
                    </span>
                </div>
            </div>
            <button v-if="pagination.current_page < pagination.last_page" @click="paginate(pagination.current_page + 1)"
                class="underline hover:font-bold">
                Próximo
            </button>
            <button v-else class="pagination-button-disabled" disabled>
                Próximo
            </button>
        </div>
    </nav>
</template>

<script setup>
const emit = defineEmits(['paginate']);
const props = defineProps({
    pagination: {
        type: [Object, Array],
        default: null
    },
    onEachSize: {
        type: Number,
        default: 0
    }
});

function paginate(page) {
    emit('paginate', page);
}

function pageShow(page, current_page, last_page) {
    let minPage = current_page - props.onEachSize;
    let maxPage = current_page + props.onEachSize;
    if (props.onEachSize == 0) {
        return true;
    }else if(page == 1 || page == last_page){
        return true;
    }
    else if (page <= maxPage && page >= minPage) {
        return true;
    }else{
        return false;
    }

}

</script>

<style scoped>
/* Mantive suas classes de estilo personalizadas */

.pagination-button {
    margin-top: 4px;
    background-color: #f2f2f2;
    border-radius: 100%;
    padding: 5px 10px;
    margin: 0px 2px;
}

.pagination-button:hover {
    background-color: #bbbbbb;
}

.pagination-button-active {
    margin-top: 4px;
    background-color: #bbbbbb;
    border-radius: 100%;
    padding: 5px 10px;
    margin: 0px 2px;
}

.pagination-button-disabled {
    margin: 0 1px;
    cursor: not-allowed;
}
</style>

<template>
    <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-col sm:flex-row sm:justify-between" v-if="pagination.last_page > 1">
        <div>
            <p class="text-sm leading-5 text-gray-700 dark:text-gray-400">
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
            <button v-else @click="paginate(pagination.current_page - 1)" class="pagination-button">
                Anterior
            </button>
            <div class="flex ">
                <div>
                    <span class="relative z-0 inline-flex rounded-md shadow-sm rtl:flex-row-reverse">
                        <button v-for="page in pagination.last_page" :key="page" @click="paginate(page)"
                            :class="{ 'pagination-button': page !== pagination.current_page, 'pagination-button-active': page === pagination.current_page }">
                            {{ page }}
                        </button>
                    </span>
                </div>
            </div>
            <button v-if="pagination.current_page < pagination.last_page" @click="paginate(pagination.current_page + 1)"
                class="pagination-button">
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
defineProps({
    pagination: {
        type: [Object, Array],
        default: null
    }
});

function paginate(page) {
    emit('paginate', page);
}

</script>

<style scoped>
/* Adicione o seguinte código ao seu bloco de estilo */

.pagination-button {
    background-color: #4a5568;
    color: #cbd5e0;
    border: 1px solid #2d3748;
    padding: 0.25rem 0.5rem;
    margin: 0.1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.pagination-button:hover {
    background-color: #2d3748;
}

.pagination-button-active {
    background-color: #2d3748;
    color: #ffffff;
    border: 1px solid #2d3748;
    padding: 0.25rem 0.5rem;
    margin: 0.1rem;
    cursor: default;
}

.pagination-button-disabled {
    background-color: #e2e8f0;
    color: #a0aec0;
    border: 1px solid #e2e8f0;
    padding: 0.25rem 0.5rem;
    margin: 0.1rem;
    cursor: not-allowed;
}
</style>


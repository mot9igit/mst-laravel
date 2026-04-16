<template>
    <div>
        <v-table
            class=""
            :filters="this.regionTable.filters"
            :items_data="this.regions.data"
            :total="this.regions.total"
            :pagination_items_per_page="this.pagination_items_per_page"
            :pagination_offset="this.pagination_offset"
            :page="this.regionTable.page"
            :table_data="this.regionTable.table_data"
            title="Страна"
            @filter="filterRegion"
            @sort="filterRegion"
            @paginate="filterRegion"
            @deleteElem="filterRegion"
        >
            <template v-slot:button>
                <div>
                    <a href="/adm/system/geo/country/create" class="btn btn-primary"> Создать регион </a>
                </div>
            </template>
        </v-table>
    </div>
</template>
<script>
import vTable from "@/components/admin/main/table/v-table.vue"
import Toast from "primevue/toast";
import ConfirmDialog from "primevue/confirmdialog";
import {mapActions, mapGetters} from "vuex";

export default{
    name: "Region",
    props: {
        pagination_items_per_page: {
            type: Number,
            default: 24,
        },
        pagination_offset: {
            type: Number,
            default: 0,
        }
    },
    components: {
        vTable,
        Toast,
        ConfirmDialog,
    },
    data() {
        return {
            confirm: null,
            toast: null,
            regionTable:{
                page: 1,
                pagination_offset: 0,
                pagination_items_per_page: 25,
                filter: {},
                filters: {
                    name: {
                        name: "Наименование",
                        placeholder: "Наименование",
                        type: "text",
                    }
                },
                table_data: {
                    id: {
                        label: "№",
                        type: "text",
                    },
                    name: {
                        label: 'Наименование',
                        type: 'text',
                    },
                    actions: {
                        label: 'Действия',
                        type: 'actions',
                        sort: false,
                        available: {
                            edit: {
                                icon: 'bi bi-pencil',
                                label: 'Редактировать'
                            },
                            delete: {
                                icon: 'bi bi-trash',
                                label: 'Удалить'
                            }
                        }
                    }
                },
            }
        }
    },
    methods: {
        ...mapActions([
            'getRegions'
        ]),
        filterRegion(data) {
            this.getRegions(data)
        },
        paginateRegion(data) {
            this.regionTable.page = data.page
            this.getRegions(data)
        },
        deleteRegion(data) {
            // 1. Запрашиваем подтверждение
            this.$confirm.require({
                message: `Вы уверены, что хотите удалить регион - ${data.name}?`,
                header: 'Подтверждение',
                icon: 'bi bi-exclamation-triangle',
                rejectProps: {
                    label: 'Отмена',
                    severity: 'secondary',
                    outlined: true
                },
                acceptProps: {
                    label: 'Да'
                },
                accept: () => {
                    // 2. Отправляем запрос на API
                    return this.$api.base.delete(`/api/system/geo/region/${data.id}`)
                        .then((response) => {
                            this.regionTable.page = 1
                            this.getRegions({
                                page: this.regionTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            if (error.response.status === 404) {
                                this.regionTable.page = 1
                                // this.$toast.add({ severity: 'error', summary: 'Не найден', detail: 'Объект не найден', life: 3000 });
                                this.getRegions({
                                    page: this.regionTable.page,
                                    perpage: this.pagination_items_per_page
                                })
                            }
                        })
                },
                reject: () => {
                    this.$toast.add({severity: 'error', summary: 'Отмена', detail: 'Действие отменено', life: 3000});
                }
            });
        },
    },
    mounted() {
        this.getRegions({
            page: this.regionTable.page,
            perpage: this.pagination_items_per_page
        })
    },
    computed: {
        ...mapGetters([
            "regions"
        ])
    },
    watch: {
    },
}
</script>
<style>

</style>

<template>
    <div>
        <v-table
            class=""
            :filters="this.cityTable.filters"
            :items_data="this.cities.data"
            :total="this.cities.total"
            :pagination_items_per_page="this.pagination_items_per_page"
            :pagination_offset="this.pagination_offset"
            :page="this.cityTable.page"
            :table_data="this.cityTable.table_data"
            title="Города"
            @filter="filterCity"
            @sort="filterCity"
            @paginate="paginateCity"
            @editElem="editCity"
            @deleteElem="deleteCity"
        >
            <template v-slot:button>
                <div>
                    <button class="btn btn-primary" @click.prevent="() => { this.city_id = 0; this.createCityWindow = true; this.createWindow.title = this.createTitle}"> Создать город </button>
                </div>
            </template>
        </v-table>
        <customModal
            v-model="createCityWindow"
        >
            <template v-slot:title>{{ this.createWindow.title }}</template>
            <create-city-component :city_id="this.city_id"></create-city-component>
        </customModal>
    </div>
</template>
<script>
import vTable from "@/components/admin/main/table/v-table.vue"
import customModal from "@/shared/ui/Modal.vue";
import CreateCityComponent from '@/components/admin/system/geo/city/CreateComponent.vue';
import Toast from "primevue/toast";
import ConfirmDialog from "primevue/confirmdialog";
import {mapActions, mapGetters} from "vuex";

export default{
    name: "City",
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
        customModal,
        CreateCityComponent,
        Toast,
        ConfirmDialog,
    },
    data() {
        return {
            city_id: 0,
            createCityWindow: false,
            createWindow: {
                title: "",
            },
            createTitle: "Создать город",
            updateTitle: "Редактировать город",
            confirm: null,
            toast: null,
            cityTable:{
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
                    name_r: {
                        label: 'Наименование, скл',
                        type: 'text',
                    },
                    population: {
                        label: 'Население',
                        type: 'text',
                    },
                    postal_code: {
                        label: 'Индекс',
                        type: 'text',
                    },
                    region: {
                        label: 'Регион',
                        type: 'text',
                        inner: 'name'
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
            'getCities'
        ]),
        filterCity(data) {
            this.getCities(data)
        },
        paginateCity(data) {
            this.cityTable.page = data.page
            this.getCities(data)
        },
        editCity(data){
            this.city_id = data.id
            this.createWindow.title = this.updateTitle
            this.createCityWindow = true
        },
        deleteCity(data) {
            // 1. Запрашиваем подтверждение
            this.$confirm.require({
                message: `Вы уверены, что хотите удалить город - ${data.name}?`,
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
                    return this.$api.base.delete(`/api/system/geo/city/${data.id}`)
                        .then(() => {
                            this.cityTable.page = 1
                            this.getCities({
                                page: this.cityTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            if (error.response.status === 404) {
                                this.cityTable.page = 1
                                // this.$toast.add({ severity: 'error', summary: 'Не найден', detail: 'Объект не найден', life: 3000 });
                                this.getCities({
                                    page: this.cityTable.page,
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
        this.getCities({
            page: this.cityTable.page,
            perpage: this.pagination_items_per_page
        })
    },
    computed: {
        ...mapGetters([
            "cities"
        ])
    },
    watch: {
    },
}
</script>
<style>

</style>

<template>
    <div>
        <v-table
            class=""
            :filters="this.countryTable.filters"
            :items_data="this.countries.data"
            :total="this.countries.total"
            :pagination_items_per_page="this.pagination_items_per_page"
            :pagination_offset="this.pagination_offset"
            :page="this.countryTable.page"
            :table_data="this.countryTable.table_data"
            title="Страна"
            @filter="filterCountry"
            @sort="filterCountry"
            @paginate="paginateCountry"
            @editElem="editCountry"
            @deleteElem="deleteCountry"
        >
            <template v-slot:button>
                <div>
                    <button class="btn btn-primary" @click.prevent="() => { this.country_id = 0; this.createCountryWindow = true, this.createWindow.title = this.createTitle}"> Создать страну </button>
                </div>
            </template>
        </v-table>
        <customModal
            v-model="createCountryWindow"
            @cancel="cancel"
        >
            <template v-slot:title>{{ this.createWindow.title }}</template>
            <create-country-component :country_id="this.country_id"></create-country-component>
        </customModal>
    </div>
</template>
<script>
import vTable from "@/components/admin/main/table/v-table.vue";
import {mapActions, mapGetters} from "vuex";
import Toast from "primevue/toast";
import ConfirmDialog from "primevue/confirmdialog";
import customModal from "@/shared/ui/Modal.vue";
import CreateCountryComponent from '@/components/admin/system/geo/country/CreateComponent.vue';

export default{
    name: "Country",
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
        customModal,
        CreateCountryComponent,
        vTable,
        Toast,
        ConfirmDialog,
    },
    data() {
        return {
            country_id: 0,
            createCountryWindow: false,
            createWindow: {
                title: "",
            },
            createTitle: "Создать страну",
            updateTitle: "Редактировать страну",
            confirm: null,
            toast: null,
            countryTable:{
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
                    key: {
                        label: 'Ключ',
                        type: 'text',
                    },
                    population: {
                        label: 'Население',
                        type: 'text',
                    },
                    active: {
                        label: 'Активна',
                        type: 'boolean',
                        calc: 'positive'
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
            'getCountries'
        ]),
        filterCountry(data) {
            this.getCountries(data)
        },
        paginateCountry(data) {
            this.countryTable.page = data.page
            this.getCountries(data)
        },
        editCountry(data){
            this.country_id = data.id
            this.createWindow.title = this.updateTitle
            this.createCountryWindow = true
        },
        deleteCountry(data) {
            // 1. Запрашиваем подтверждение
            this.$confirm.require({
                message: `Вы уверены, что хотите удалить страну - ${data.name}?`,
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
                    return this.$api.base.delete(`/api/system/geo/country/${data.id}`)
                        .then((response) => {
                            this.countryTable.page = 1
                            this.getCountries({
                                page: this.countryTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            if (error.response.status === 404) {
                                this.countryTable.page = 1
                                // this.$toast.add({ severity: 'error', summary: 'Не найден', detail: 'Объект не найден', life: 3000 });
                                this.getCountries({
                                    page: this.countryTable.page,
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
        this.getCountries({
            page: this.countryTable.page,
            perpage: this.pagination_items_per_page
        })
    },
    computed: {
        ...mapGetters([
            "countries"
        ])
    },
    watch: {
    },
}
</script>
<style>

</style>

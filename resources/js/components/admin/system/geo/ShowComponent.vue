<template>
    <div class="card card-primary card-outline mb-4">
        <Toast />
        <ConfirmDialog></ConfirmDialog>
        <Tabs value="0">
            <TabList>
                <Tab value="0">Города</Tab>
                <Tab value="1">Регионы</Tab>
                <Tab value="2">Страны</Tab>
            </TabList>
            <TabPanels>
                <TabPanel value="0">
                    <show-city-component/>
                </TabPanel>
                <TabPanel value="1">
                    <show-region-component/>
                </TabPanel>
                <TabPanel value="2">
                    <show-country-component/>
                </TabPanel>
            </TabPanels>
        </Tabs>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Toast from 'primevue/toast';
import ConfirmDialog from "primevue/confirmdialog";
import Tabs from 'primevue/tabs';
import TabList from 'primevue/tablist';
import Tab from 'primevue/tab';
import TabPanels from 'primevue/tabpanels';
import TabPanel from 'primevue/tabpanel';
import vTable from "@/components/admin/main/table/v-table.vue";
import Axios from "axios";
import ShowCountryComponent from '@/components/admin/system/geo/country/ShowComponent.vue';
import ShowRegionComponent from '@/components/admin/system/geo/region/ShowComponent.vue';
import ShowCityComponent from '@/components/admin/system/geo/city/ShowComponent.vue';

export default {
    name: "SystemGeo",
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
    data() {
        return {
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
                    actions: {
                        label: 'Действия',
                        type: 'actions',
                        sort: false,
                        available: {
                            edit: {
                                icon: 'bi bi-eye',
                                label: 'Подробнее'
                            },
                            delete: {
                                icon: 'bi bi-trash',
                                label: 'Удалить'
                            }
                        }
                    }
                },
            },
            regionsTable:{
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
                                icon: 'bi bi-eye',
                                label: 'Подробнее'
                            },
                            delete: {
                                icon: 'bi bi-trash',
                                label: 'Удалить'
                            }
                        }
                    }
                },
            },
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
                    actions: {
                        label: 'Действия',
                        type: 'actions',
                        sort: false,
                        available: {
                            edit: {
                                icon: 'bi bi-eye',
                                label: 'Подробнее'
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
            'getCities',
            'getRegions',
            'getCountries'
        ]),
        filterCity (data) {
            this.getCities(data)
        },
        paginateCity (data) {
            this.cityTable.page = data.page
            this.getCities(data)
        },
        deleteCity (data) {
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
                    return Axios(`/api/system/geo/city/${data.id}`, {
                        method: 'DELETE'
                    })
                        .then((response) => {
                            this.cityTable.page = 1
                            this.getCities({
                                page: this.cityTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            if (error.response.status === 404) {
                                this.$toast.add({ severity: 'error', summary: 'Не найден', detail: 'Объект не найден', life: 3000 });
                                this.getCities({
                                    page: this.cityTable.page,
                                    perpage: this.pagination_items_per_page
                                })
                            }
                            if (error.response.status === 500) {
                                this.$toast.add({ severity: 'error', summary: 'Ошибка', detail: 'Внутренняя ошибка сервера', life: 3000 });
                            }
                            if (error.response.status === 403) {
                                // TODO: to auth page
                            }
                        })
                },
                reject: () => {
                    this.$toast.add({ severity: 'error', summary: 'Отмена', detail: 'Действие отменено', life: 3000 });
                }
            });
        },
        filterRegion (data) {
            this.getRegions(data)
        },
        paginateRegion (data) {
            this.regionsTable.page = data.page
            this.getRegions(data)
        },
        deleteRegion (data) {
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
                    return Axios(`/api/system/geo/region/${data.id}`, {
                        method: 'DELETE'
                    })
                        .then((response) => {
                            this.regionTable.page = 1
                            this.getCities({
                                page: this.regionsTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            if (error.response.status === 404) {
                                this.$toast.add({ severity: 'error', summary: 'Не найден', detail: 'Объект не найден', life: 3000 });
                                this.getCities({
                                    page: this.regionsTable.page,
                                    perpage: this.pagination_items_per_page
                                })
                            }
                            if (error.response.status === 500) {
                                this.$toast.add({ severity: 'error', summary: 'Ошибка', detail: 'Внутренняя ошибка сервера', life: 3000 });
                            }
                            if (error.response.status === 403) {
                                // TODO: to auth page
                            }
                        })
                },
                reject: () => {
                    this.$toast.add({ severity: 'error', summary: 'Отмена', detail: 'Действие отменено', life: 3000 });
                }
            });
        },
        filterCountry (data) {
            this.getCountries(data)
        },
        paginateCountry (data) {
            this.countryTable.page = data.page
            this.getCountries(data)
        },
        deleteCountry (data) {
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
                    return Axios(`/api/system/geo/country/${data.id}`, {
                        method: 'DELETE'
                    })
                        .then((response) => {
                            this.regionTable.page = 1
                            this.getCities({
                                page: this.countryTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            if (error.response.status === 404) {
                                this.$toast.add({ severity: 'error', summary: 'Не найден', detail: 'Объект не найден', life: 3000 });
                                this.getCities({
                                    page: this.countryTable.page,
                                    perpage: this.pagination_items_per_page
                                })
                            }
                            if (error.response.status === 500) {
                                this.$toast.add({ severity: 'error', summary: 'Ошибка', detail: 'Внутренняя ошибка сервера', life: 3000 });
                            }
                            if (error.response.status === 403) {
                                // TODO: to auth page
                            }
                        })
                },
                reject: () => {
                    this.$toast.add({ severity: 'error', summary: 'Отмена', detail: 'Действие отменено', life: 3000 });
                }
            });
        }
    },
    mounted() {
        this.getCities({
            page: this.cityTable.page,
            perpage: this.pagination_items_per_page
        });
        this.getRegions({
            page: this.cityTable.page,
            perpage: this.pagination_items_per_page
        });
        this.getCountries({
            page: this.countryTable.page,
            perpage: this.pagination_items_per_page
        })
    },
    components: {
        vTable,
        ShowCountryComponent,
        ShowRegionComponent,
        ShowCityComponent,
        Toast,
        ConfirmDialog,
        Tabs,
        TabList,
        Tab,
        TabPanels,
        TabPanel
    },
    computed: {
        ...mapGetters([
            "cities",
            "regions",
            "countries"
        ])
    },
    watch: {
    },
};
</script>

<style lang="scss">

</style>

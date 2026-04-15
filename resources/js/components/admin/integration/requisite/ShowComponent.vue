<template>
    <div class="dart-container">
        <Toast />
        <ConfirmDialog></ConfirmDialog>
        <div class="dart-row">
            <div class="d-col-md-24">
                <v-table
                    class=""
                    :filters="this.requisiteTable.filters"
                    :items_data="requisites.data"
                    :total="requisites.total"
                    :pagination_items_per_page="this.pagination_items_per_page"
                    :pagination_offset="this.pagination_offset"
                    :page="this.requisiteTable.page"
                    :table_data="this.requisiteTable.table_data"
                    title="Пользователи"
                    @filter="filter"
                    @sort="filter"
                    @paginate="paginate"
                    @deleteElem="deleteElem"
                    @editElem="editElem"
                >
                    <template v-slot:button>
                        <div>
                            <a :href="'/adm/organization/' + this.org_id + '/requisite/create'" class="btn btn-primary"> Создать реквизиты </a>
                        </div>
                    </template>
                </v-table>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Toast from 'primevue/toast';
import ConfirmDialog from "primevue/confirmdialog";
import vTable from "../../../admin/main/table/v-table.vue";
import Axios from "axios";

export default {
    name: "Requisite",
    props: {
        pagination_items_per_page: {
            type: Number,
            default: 24,
        },
        pagination_offset: {
            type: Number,
            default: 0,
        },
        org_id: {
            type: Number,
            default: 0,
        },
    },
    data() {
        return {
            confirm: null,
            toast: null,
            requisiteTable:{
                page: 1,
                pagination_offset: 0,
                pagination_items_per_page: 24,
                filter: {},
                filters: {
                    name: {
                        name: "Наименование",
                        placeholder: "Наименование, ИНН",
                        type: "text",
                    }
                },
                table_data: {
                    id: {
                        label: "ID",
                        type: "text",
                    },
                    name: {
                        label: 'Наименование',
                        type: 'text',
                    },
                    inn: {
                        label: 'ИНН',
                        type: 'text',
                    },
                    ogrn: {
                        label: 'ОГРН',
                        type: 'text',
                    },
                    kpp: {
                        label: 'КПП',
                        type: 'text'
                    },
                    ur_address: {
                        label: 'Юр. адрес',
                        type: 'text'
                    },
                    fact_address: {
                        label: 'Факт. адрес',
                        type: 'text'
                    },
                    description: {
                        label: 'Описание',
                        type: 'text'
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
        };
    },
    methods: {
        ...mapActions([
            'getRequisites'
        ]),
        filter (data) {
            data.org_id = this.org_id
            this.getRequisites(data)
        },
        paginate (data) {
            data.org_id = this.org_id
            this.requisiteTable.page = data.page
            this.getRequisites(data)
        },
        editElem(data){
            window.location.href = '/adm/organization/' + this.org_id + '/requisite/' + data.id
        },
        deleteElem (data) {
            // 1. Запрашиваем подтверждение
            this.$confirm.require({
                message: `Вы уверены, что хотите удалить реквизиты - ${data.name}?`,
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
                    this.$api.base.delete(`/api/integration/requisite/${data.id}`)
                        .then((response) => {
                            this.requisiteTable.page = 1
                            this.getRequisites({
                                org_id: this.org_id,
                                page: this.requisiteTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            if (error.response.status === 404) {
                                this.requisiteTable.page = 1
                                // this.$toast.add({ severity: 'error', summary: 'Не найден', detail: 'Объект не найден', life: 3000 });
                                this.getRequisites({
                                    org_id: this.org_id,
                                    page: this.requisiteTable.page,
                                    perpage: this.pagination_items_per_page
                                })
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
        this.getRequisites({
            org_id: this.org_id,
            page: this.requisiteTable.page,
            perpage: this.pagination_items_per_page
        })
    },
    components: {
        vTable,
        Toast,
        ConfirmDialog
    },
    computed: {
        ...mapGetters([
            "requisites"
        ])
    },
    watch: {
    },
};
</script>

<style lang="scss">
</style>

<template>
    <div class="dart-container">
        <Toast />
        <ConfirmDialog></ConfirmDialog>
        <div class="dart-row">
            <div class="d-col-md-24">
                <v-table
                    class=""
                    :filters="this.bankRequisiteTable.filters"
                    :items_data="bankRequisites.data"
                    :total="bankRequisites.total"
                    :pagination_items_per_page="this.pagination_items_per_page"
                    :pagination_offset="this.pagination_offset"
                    :page="this.bankRequisiteTable.page"
                    :table_data="this.bankRequisiteTable.table_data"
                    title="Банковские реквизиты"
                    @filter="filter"
                    @sort="filter"
                    @paginate="paginate"
                    @deleteElem="deleteElem"
                    @editElem="editElem"
                >
                    <template v-slot:button>
                        <div>
                            <a :href="'/adm/organization/' + this.org_id + '/requisite/' + this.requisite_id + '/bank-requisite/create'" class="btn btn-primary"> Создать банковские реквизиты </a>
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
    name: "BankRequisite",
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
        requisite_id: {
            type: Number,
            default: 0,
        },
    },
    data() {
        return {
            confirm: null,
            toast: null,
            bankRequisiteTable:{
                page: 1,
                pagination_offset: 0,
                pagination_items_per_page: 24,
                filter: {},
                filters: {
                    name: {
                        name: "Наименование",
                        placeholder: "Наименование банка, БИК, р/c",
                        type: "text",
                    }
                },
                table_data: {
                    id: {
                        label: "ID",
                        type: "text",
                    },
                    name: {
                        label: 'Наименование банка',
                        type: 'text',
                    },
                    bik: {
                        label: 'БИК',
                        type: 'text',
                    },
                    number: {
                        label: 'Р/С',
                        type: 'text',
                    },
                    knumber: {
                        label: 'К/C',
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
            'getBankRequisites'
        ]),
        filter (data) {
            data.org_id = this.org_id
            data.requisite_id = this.requisite_id
            this.getBankRequisites(data)
        },
        paginate (data) {
            data.org_id = this.org_id
            data.requisite_id = this.requisite_id
            this.bankRequisiteTable.page = data.page
            this.getBankRequisites(data)
        },
        editElem(data){
            window.location.href = '/adm/organization/' + this.org_id + '/requisite/' + this.requisite_id + '/bank-requisite/' + data.id
        },
        deleteElem (data) {
            // 1. Запрашиваем подтверждение
            this.$confirm.require({
                message: `Вы уверены, что хотите удалить банковские реквизиты - ${data.name}?`,
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
                    this.$api.base.delete(`/api/integration/bank-requisite/${data.id}`)
                        .then((response) => {
                            this.bankRequisiteTable.page = 1
                            this.getBankRequisites({
                                org_id: this.org_id,
                                requisite_id: this.requisite_id,
                                page: this.bankRequisiteTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            if (error.response.status === 404) {
                                this.bankRequisiteTable.page = 1
                                // this.$toast.add({ severity: 'error', summary: 'Не найден', detail: 'Объект не найден', life: 3000 });
                                this.getBankRequisites({
                                    org_id: this.org_id,
                                    requisite_id: this.requisite_id,
                                    page: this.bankRequisiteTable.page,
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
        this.getBankRequisites({
            org_id: this.org_id,
            requisite_id: this.requisite_id,
            page: this.bankRequisiteTable.page,
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
            "bankRequisites"
        ])
    },
    watch: {
    },
};
</script>

<style lang="scss">
</style>

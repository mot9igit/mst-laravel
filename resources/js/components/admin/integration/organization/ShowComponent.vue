<template>
    <div class="dart-container">
        <Toast />
        <ConfirmDialog></ConfirmDialog>
        <div class="dart-row">
            <div class="d-col-md-24">
                <v-table
                    class=""
                    :filters="this.organizationTable.filters"
                    :items_data="organizations.data"
                    :total="organizations.total"
                    :pagination_items_per_page="this.pagination_items_per_page"
                    :pagination_offset="this.pagination_offset"
                    :page="this.organizationTable.page"
                    :table_data="this.organizationTable.table_data"
                    title="Пользователи"
                    @filter="filter"
                    @sort="filter"
                    @paginate="paginate"
                    @deleteElem="deleteElem"
                    @editElem="editElem"
                >
                    <template v-slot:button>
                        <div>
                            <a href="/adm/organization/create" class="btn btn-primary"> Создать организацию </a>
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
    name: "Organization",
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
            organizationTable:{
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
                    email: {
                        label: 'E-mail',
                        type: 'text',
                        sort: true,
                    },
                    phone: {
                        label: 'Телефон',
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
        };
    },
    methods: {
        ...mapActions([
            'getOrganizations'
        ]),
        filter (data) {
            this.getOrganizations(data)
        },
        paginate (data) {
            this.organizationTable.page = data.page
            this.getOrganizations(data)
        },
        editElem(data){
            window.location.href = '/adm/integration/organization/' + data.id
        },
        deleteElem (data) {
            // 1. Запрашиваем подтверждение
            this.$confirm.require({
                message: `Вы уверены, что хотите удалить организацию - ${data.name}?`,
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
                    return Axios(`/api/integration/organization/${data.id}`, {
                        method: 'DELETE'
                    })
                        .then((response) => {
                            this.organizationTable.page = 1
                            this.getOrganizations({
                                page: this.organizationTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            if (error.response.status === 404) {
                                this.organizationTable.page = 1
                                this.$toast.add({ severity: 'error', summary: 'Не найден', detail: 'Объект не найден', life: 3000 });
                                this.getOrganizations({
                                    page: this.organizationTable.page,
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
        this.getOrganizations({
            page: this.organizationTable.page,
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
            "organizations"
        ])
    },
    watch: {
    },
};
</script>

<style lang="scss">
</style>

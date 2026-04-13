<template>
    <div>
        <div class="dart-row">
            <div class="d-col-md-24">
                <v-table
                    class=""
                    :filters="this.organizationUsersTable.filters"
                    :items_data="organizationUsers.data"
                    :total="organizationUsers.total"
                    :pagination_items_per_page="this.pagination_items_per_page"
                    :pagination_offset="this.pagination_offset"
                    :page="this.organizationUsersTable.page"
                    :table_data="this.organizationUsersTable.table_data"
                    title="Пользователи"
                    @filter="filter"
                    @sort="filter"
                    @paginate="paginate"
                    @deleteElem="deleteElem"
                    @editElem="editElem"
                >
                    <template v-slot:button>
                        <div>
                            <button class="btn btn-primary" @click.prevent="linkWindow = true"> Привязать пользователя </button>
                        </div>
                    </template>
                </v-table>
            </div>
        </div>
        <customModal
            v-model="linkWindow"
            @cancel="cancel"
        >
            <template v-slot:title>Привязать пользователя</template>
            <link-user-component :org_id="this.org_id"></link-user-component>
        </customModal>
    </div>
</template>

<script>
import ConfirmDialog from "primevue/confirmdialog";
import Toast from "primevue/toast";
import vTable from "../../../admin/main/table/v-table.vue";
import customModal from "../../../../shared/ui/Modal.vue";
import LinkUserComponent from "../user/LinkUserComponent.vue";
import {mapActions, mapGetters} from "vuex";
import Axios from "axios";

export default{
    name: "ShowOrganizationUserComponent",
    components: {
        vTable,
        Toast,
        ConfirmDialog,
        customModal,
        LinkUserComponent
    },
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
        }
    },
    data() {
        return {
            linkWindow: false,
            confirm: null,
            toast: null,
            organizationUsersTable:{
                page: 1,
                pagination_offset: 0,
                pagination_items_per_page: 24,
                filter: {},
                filters: {
                    name: {
                        name: "ФИО, Email",
                        placeholder: "ФИО, Email",
                        type: "text",
                    }
                },
                table_data: {
                    id: {
                        label: "ID",
                        type: "text",
                    },
                    name: {
                        label: 'Логин',
                        type: 'text',
                    },
                    fullname: {
                        label: 'Ф. И. О.',
                        type: 'text',
                    },
                    email: {
                        label: 'E-mail',
                        type: 'text',
                    },
                    phone: {
                        label: 'Телефон',
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
            'getOrganizationUsers'
        ]),
        filter (data) {
            data.org_id = this.org_id
            this.getOrganizationUsers(data)
        },
        paginate (data) {
            data.org_id = this.org_id
            this.organizationUsersTable.page = data.page
            this.getOrganizationUsers(data)
        },
        deleteElem (data) {
            // 1. Запрашиваем подтверждение
            this.$confirm.require({
                message: `Вы уверены, что хотите отвязать пользователя - ${data.name}?`,
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
                    return Axios(`/api/integration/organization/${this.org_id}/user/${data.id}`, {
                        method: 'DELETE'
                    })
                        .then((response) => {
                            this.organizationUsersTable.page = 1
                            this.getOrganizationUsers({
                                org_id: this.org_id,
                                page: this.organizationUsersTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            if (error.response.status === 404) {
                                this.organizationUsersTable.page = 1
                                this.$toast.add({ severity: 'error', summary: 'Не найден', detail: 'Объект не найден', life: 3000 });
                                this.getOrganizationUsers({
                                    org_id: this.org_id,
                                    page: this.organizationUsersTable.page,
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
        this.getOrganizationUsers({
            org_id: this.org_id,
            page: this.organizationUsersTable.page,
            perpage: this.pagination_items_per_page
        })
    },
    computed: {
        ...mapGetters([
            "organizationUsers"
        ])
    },
}
</script>

<style lang="scss">
.modal__content{
    overflow: hidden;
}
</style>

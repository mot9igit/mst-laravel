<template>
    <div>
        <div class="dart-row">
            <div class="d-col-md-24">
                <v-table
                    class=""
                    :filters="this.contactPersonTable.filters"
                    :items_data="contactPersons.data"
                    :total="contactPersons.total"
                    :pagination_items_per_page="this.pagination_items_per_page"
                    :pagination_offset="this.pagination_offset"
                    :page="this.contactPersonTable.page"
                    :table_data="this.contactPersonTable.table_data"
                    title="Контактные лица"
                    @filter="filter"
                    @sort="filter"
                    @paginate="paginate"
                    @deleteElem="deleteElem"
                    @editElem="editElem"
                >
                    <template v-slot:button>
                        <div>
                            <button class="btn btn-primary" @click.prevent="linkWindow = true"> Создать контактное лицо </button>
                        </div>
                    </template>
                </v-table>
            </div>
        </div>
        <customModal
            v-model="linkWindow"
            @cancel="cancel"
        >
            <template v-slot:title>Создать контактное лицо</template>
            <create-contact-person-component :org_id="this.org_id"></create-contact-person-component>
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
import CreateContactPersonComponent from "./CreateContactPersonComponent.vue";

export default{
    name: "ShowOrganizationContactPersonComponent",
    components: {
        CreateContactPersonComponent,
        LinkContactPersonComponent: CreateContactPersonComponent,
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
            contactPersonTable:{
                page: 1,
                pagination_offset: 0,
                pagination_items_per_page: 24,
                filter: {},
                filters: {
                    name: {
                        name: "ФИО, Телефон, Email",
                        placeholder: "ФИО, Телефон, Email",
                        type: "text",
                    }
                },
                table_data: {
                    id: {
                        label: "ID",
                        type: "text",
                    },
                    name: {
                        label: 'Имя',
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
            'getContactPersons'
        ]),
        filter (data) {
            data.org_id = this.org_id
            this.getContactPersons(data)
        },
        paginate (data) {
            data.org_id = this.org_id
            this.contactPersonTable.page = data.page
            this.getContactPersons(data)
        },
        deleteElem (data) {
            this.$confirm.require({
                message: `Вы уверены, что хотите удалить контактное лицо - ${data.name}?`,
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
                    return Axios(`/api/integrations/contact-person/${data.id}`, {
                        method: 'DELETE'
                    })
                        .then(() => {
                            this.contactPersonTable.page = 1
                            this.getContactPersons({
                                org_id: this.org_id,
                                page: this.contactPersonTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            if (error.response.status === 404) {
                                this.contactPersonTable.page = 1
                                this.$toast.add({ severity: 'error', summary: 'Не найден', detail: 'Объект не найден', life: 3000 });
                                this.getContactPersons({
                                    org_id: this.org_id,
                                    page: this.contactPersonTable.page,
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
        this.getContactPersons({
            org_id: this.org_id,
            filter: '',
            page: this.contactPersonTable.page,
            perpage: this.pagination_items_per_page
        })
    },
    computed: {
        ...mapGetters([
            "contactPersons"
        ])
    },
}
</script>

<style lang="scss">
.modal__content{
    overflow-x: hidden;
}
</style>

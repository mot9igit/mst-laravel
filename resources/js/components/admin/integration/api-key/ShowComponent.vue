<template>
    <div>
        <div class="dart-row">
            <div class="d-col-md-24">
                <v-table
                    class=""
                    :filters="this.apiKeyTable.filters"
                    :items_data="apiKeys.data"
                    :total="apiKeys.total"
                    :pagination_items_per_page="this.pagination_items_per_page"
                    :pagination_offset="this.pagination_offset"
                    :page="this.apiKeyTable.page"
                    :table_data="this.apiKeyTable.table_data"
                    title="Ключи API"
                    @filter="filter"
                    @sort="filter"
                    @paginate="paginate"
                    @deleteElem="deleteElem"
                    @editElem="editElem"
                >
                    <template v-slot:button>
                        <div>
                            <button class="btn btn-primary" @click.prevent="linkWindow = true"> Создать API ключ </button>
                        </div>
                    </template>
                </v-table>
            </div>
        </div>
        <customModal
            v-model="linkWindow"
            @cancel="cancel"
        >
            <template v-slot:title>Создать API ключ</template>
            <create-api-key-component :org_id="this.org_id"></create-api-key-component>
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
import CreateApiKeyComponent from "./CreateApiKeyComponent.vue";

export default{
    name: "ShowApiKeyComponent",
    components: {
        CreateApiKeyComponent,
        CreateContactPersonComponent: CreateApiKeyComponent,
        LinkContactPersonComponent: CreateApiKeyComponent,
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
            apiKeyTable:{
                page: 1,
                pagination_offset: 0,
                pagination_items_per_page: 24,
                filter: {},
                filters: {
                    name: {
                        name: "Ключ, описание",
                        placeholder: "Ключ, описание",
                        type: "text",
                    }
                },
                table_data: {
                    id: {
                        label: "ID",
                        type: "text",
                    },
                    key: {
                        label: 'Ключ',
                        type: 'text',
                    },
                    description: {
                        label: 'Описание',
                        type: 'text',
                    },
                    store_name:{
                        label: 'Точка продажи',
                        type: 'text',
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
            'getApiKeys'
        ]),
        filter (data) {
            data.org_id = this.org_id
            this.getApiKeys(data)
        },
        paginate (data) {
            data.org_id = this.org_id
            this.apiKeyTable.page = data.page
            this.getApiKeys(data)
        },
        deleteElem (data) {
            this.$confirm.require({
                message: `Вы уверены, что хотите удалить API ключ - ${data.key}?`,
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
                    return Axios(`/api/integrations/api-key/${data.id}`, {
                        method: 'DELETE'
                    })
                        .then(() => {
                            this.apiKeyTable.page = 1
                            this.getApiKeys({
                                org_id: this.org_id,
                                page: this.apiKeyTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            if (error.response.status === 404) {
                                this.apiKeyTable.page = 1
                                this.$toast.add({ severity: 'error', summary: 'Не найден', detail: 'Объект не найден', life: 3000 });
                                this.getApiKeys({
                                    org_id: this.org_id,
                                    page: this.apiKeyTable.page,
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
        this.getApiKeys({
            org_id: this.org_id,
            filter: '',
            page: this.apiKeyTable.page,
            perpage: this.pagination_items_per_page
        })
    },
    computed: {
        ...mapGetters([
            "apiKeys"
        ])
    },
}
</script>

<style lang="scss">
.modal__content{
    overflow-x: hidden;
}
</style>

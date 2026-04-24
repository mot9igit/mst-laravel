<template>
    <div>
        <div class="dart-row">
            <div class="d-col-md-24">
                <v-table
                    class=""
                    :filters="this.organizationStoresTable.filters"
                    :items_data="organizationStores.data"
                    :total="organizationStores.total"
                    :pagination_items_per_page="this.pagination_items_per_page"
                    :pagination_offset="this.pagination_offset"
                    :page="this.organizationStoresTable.page"
                    :table_data="this.organizationStoresTable.table_data"
                    title="Пользователи"
                    @filter="filter"
                    @sort="filter"
                    @paginate="paginate"
                    @deleteElem="deleteElem"
                    @editElem="editElem"
                >
                    <template v-slot:button>
                        <div>
                            <button class="btn btn-primary" @click.prevent="linkWindow = true"> Привязать точку продаж </button>
                        </div>
                    </template>
                </v-table>
            </div>
        </div>
        <customModal
            v-model="linkWindow"
            @cancel="cancel"
        >
            <template v-slot:title>Привязать точку продаж</template>
            <link-store-component :org_id="this.org_id"></link-store-component>
        </customModal>
    </div>
</template>

<script>
import ConfirmDialog from "primevue/confirmdialog";
import Toast from "primevue/toast";
import vTable from "@/components/admin/main/table/v-table.vue";
import customModal from "@/shared/ui/Modal.vue";
import LinkStoreComponent from "../store/LinkStoreComponent.vue";
import {mapActions, mapGetters} from "vuex";
import Axios from "axios";

export default{
    name: "ShowOrganizationStoreComponent",
    components: {
        vTable,
        Toast,
        ConfirmDialog,
        customModal,
        LinkStoreComponent
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
            organizationStoresTable:{
                page: 1,
                pagination_offset: 0,
                pagination_items_per_page: 24,
                filter: {},
                filters: {
                    name: {
                        name: "Наименование, адрес",
                        placeholder: "Наименование, адрес",
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
                    address: {
                        label: 'Адрес',
                        type: 'text',
                    },
                    pivot: {
                        label: 'Описание',
                        inner: 'description',
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
            'getOrganizationStores'
        ]),
        filter (data) {
            data.org_id = this.org_id
            this.getOrganizationStores(data)
        },
        paginate (data) {
            data.org_id = this.org_id
            this.organizationStoresTable.page = data.page
            this.getOrganizationStores(data)
        },
        deleteElem (data) {
            // 1. Запрашиваем подтверждение
            this.$confirm.require({
                message: `Вы уверены, что хотите отвязать точку продаж - ${data.name}?`,
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
                    return Axios(`/api/integration/organization/${this.org_id}/store/${data.id}`, {
                        method: 'DELETE'
                    })
                        .then(() => {
                            this.organizationStoresTable.page = 1
                            this.getOrganizationStores({
                                org_id: this.org_id,
                                page: this.organizationStoresTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            if (error.response.status === 404) {
                                this.getOrganizationStores.page = 1
                                this.$toast.add({ severity: 'error', summary: 'Не найден', detail: 'Объект не найден', life: 3000 });
                                this.getOrganizationStores({
                                    org_id: this.org_id,
                                    page: this.organizationStoresTable.page,
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
        this.getOrganizationStores({
            org_id: this.org_id,
            page: this.organizationStoresTable.page,
            perpage: this.pagination_items_per_page
        })
    },
    computed: {
        ...mapGetters([
            "organizationStores"
        ])
    },
}
</script>

<style lang="scss">
.modal__content{
    overflow-x: hidden;
}
</style>

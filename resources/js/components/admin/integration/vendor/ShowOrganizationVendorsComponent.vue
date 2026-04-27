<template>
    <div>
        <div class="dart-row">
            <div class="d-col-md-24">
                <v-table
                    class=""
                    :filters="this.organizationVendorsTable.filters"
                    :items_data="organizationVendors.data"
                    :total="organizationVendors.total"
                    :pagination_items_per_page="this.pagination_items_per_page"
                    :pagination_offset="this.pagination_offset"
                    :page="this.organizationVendorsTable.page"
                    :table_data="this.organizationVendorsTable.table_data"
                    title="Бренды"
                    @filter="filter"
                    @sort="filter"
                    @paginate="paginate"
                    @deleteElem="deleteElem"
                >
                    <template v-slot:button>
                        <div>
                            <button class="btn btn-primary" @click.prevent="linkWindow = true"> Привязать бренд </button>
                        </div>
                    </template>
                </v-table>
            </div>
        </div>
        <customModal
            v-model="linkWindow"
            @cancel="cancel"
        >
            <template v-slot:title>Привязать бренд</template>
            <link-vendor-component :org_id="this.org_id"></link-vendor-component>
        </customModal>
    </div>
</template>

<script>
import ConfirmDialog from "primevue/confirmdialog";
import Toast from "primevue/toast";
import vTable from "@/components/admin/main/table/v-table.vue";
import customModal from "@/shared/ui/Modal.vue";
import LinkVendorComponent from "@/components/admin/integration/vendor/LinkVendorComponent.vue";
import {mapActions, mapGetters} from "vuex";
import Axios from "axios";

export default{
    name: "ShowOrganizationVendorComponent",
    components: {
        vTable,
        Toast,
        ConfirmDialog,
        customModal,
        LinkVendorComponent
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
            organizationVendorsTable:{
                page: 1,
                pagination_offset: 0,
                pagination_items_per_page: 24,
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
                        label: "ID",
                        type: "text",
                    },
                    name: {
                        label: 'Наименование',
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
            'getOrganizationVendors'
        ]),
        filter (data) {
            data.org_id = this.org_id
            this.getOrganizationVendors(data)
        },
        paginate (data) {
            data.org_id = this.org_id
            this.organizationVendorsTable.page = data.page
            this.getOrganizationVendors(data)
        },
        deleteElem (data) {
            // 1. Запрашиваем подтверждение
            this.$confirm.require({
                message: `Вы уверены, что хотите отвязать бренд - ${data.name}?`,
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
                    return Axios(`/api/integration/organization/${this.org_id}/vendor/${data.id}`, {
                        method: 'DELETE'
                    })
                        .then(() => {
                            this.organizationVendorsTable.page = 1
                            this.getOrganizationVendors({
                                org_id: this.org_id,
                                page: this.organizationVendorsTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            if (error.response.status === 404) {
                                this.organizationVendorsTable.page = 1
                                this.$toast.add({ severity: 'error', summary: 'Не найден', detail: 'Объект не найден', life: 3000 });
                                this.getOrganizationVendors({
                                    org_id: this.org_id,
                                    page: this.organizationVendorsTable.page,
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
        this.getOrganizationVendors({
            org_id: this.org_id,
            page: this.organizationVendorsTable.page,
            perpage: this.pagination_items_per_page
        })
    },
    computed: {
        ...mapGetters([
            "organizationVendors"
        ])
    },
}
</script>

<style lang="scss">
.modal__content{
    overflow-x: hidden;
}
</style>

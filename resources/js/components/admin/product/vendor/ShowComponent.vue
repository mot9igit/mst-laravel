<template>
    <div class="dart-container">
        <Toast />
        <ConfirmDialog></ConfirmDialog>
        <div class="dart-row">
            <div class="d-col-md-24">
                <v-table
                    class=""
                    :filters="this.vendorTable.filters"
                    :items_data="vendors.data"
                    :total="vendors.total"
                    :pagination_items_per_page="this.pagination_items_per_page"
                    :pagination_offset="this.pagination_offset"
                    :page="this.vendorTable.page"
                    :table_data="this.vendorTable.table_data"
                    title="Бренды"
                    @filter="filter"
                    @sort="filter"
                    @paginate="paginate"
                    @deleteElem="deleteElem"
                    @editElem="editElem"
                >
                    <template v-slot:button>
                        <div>
                            <button class="btn btn-primary" @click.prevent="() => { this.vendor_id = 0; this.createVendorWindow = true; this.createWindow.title = this.createTitle}"> Создать бренд </button>
                        </div>
                    </template>
                </v-table>
            </div>
        </div>
        <customModal
            v-model="createVendorWindow"
        >
            <template v-slot:title>{{ this.createWindow.title }}</template>
            <create-product-vendor-component :vendor_id="this.vendor_id"></create-product-vendor-component>
        </customModal>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Toast from 'primevue/toast';
import ConfirmDialog from "primevue/confirmdialog";
import vTable from "@/components/admin/main/table/v-table.vue";
import customModal from "@/shared/ui/Modal.vue";
import CreateProductVendorComponent from "@/components/admin/product/vendor/CreateComponent.vue";

export default {
    name: "Vendors",
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
            vendor_id: 0,
            createVendorWindow: false,
            createWindow: {
                title: "",
            },
            createTitle: "Создать бренд",
            updateTitle: "Редактировать бренд",
            confirm: null,
            toast: null,
            vendorTable:{
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
                        label: "№",
                        type: "text",
                    },
                    name: {
                        label: 'Наименование',
                        type: 'text',
                    },
                    thumb_url: {
                        label: 'Изображение',
                        type: 'image',
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
            'getVendors'
        ]),
        filter (data) {
            this.getVendors(data)
        },
        paginate (data) {
            this.vendorTable.page = data.page
            this.getVendors(data)
        },
        editElem(data){
            this.vendor_id = data.id
            this.createWindow.title = this.updateTitle
            this.createVendorWindow = true
        },
        deleteElem (data) {
            // 1. Запрашиваем подтверждение
            this.$confirm.require({
                message: `Вы уверены, что хотите удалить бренд - ${data.name}?`,
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
                    this.$api.base.delete(`/api/product/vendor/${data.id}`)
                        .then((response) => {
                            this.vendorTable.page = 1
                            this.getVendors({
                                page: this.vendorTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            if (error.response.status === 404) {
                                this.vendorTable.page = 1
                                // this.$toast.add({ severity: 'error', summary: 'Не найден', detail: 'Объект не найден', life: 3000 });
                                this.getVendors({
                                    page: this.vendorTable.page,
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
        this.getVendors({
            page: this.vendorTable.page,
            perpage: this.pagination_items_per_page
        })
    },
    components: {
        CreateProductVendorComponent,
        customModal,
        vTable,
        Toast,
        ConfirmDialog
    },
    computed: {
        ...mapGetters([
            "vendors"
        ])
    },
    watch: {
    },
};
</script>

<style lang="scss">
</style>

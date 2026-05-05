<template>
    <div class="dart-container">
        <div class="dart-row">
            <div class="d-col-md-24">
                <v-table
                    class=""
                    :filters="this.remainPriceTable.filters"
                    :items_data="remainPrices.data"
                    :total="remainPrices.total"
                    :pagination_items_per_page="this.pagination_items_per_page"
                    :pagination_offset="this.pagination_offset"
                    :page="this.remainPriceTable.page"
                    :table_data="this.remainPriceTable.table_data"
                    title="Цены"
                    @filter="filter"
                    @sort="filter"
                    @paginate="paginate"
                    @deleteElem="deleteElem"
                    @editElem="editElem"
                >
                    <template v-slot:button>
                        <div>
                            <button class="btn btn-primary" @click.prevent="() => { this.price_id = 0; this.createRemainPriceWindow = true, this.createWindow.title = this.createTitle}"> Создать цену </button>
                        </div>
                    </template>
                </v-table>
            </div>
        </div>
        <customModal
            v-model="createRemainPriceWindow"
            @cancel="cancel"
        >
            <template v-slot:title>{{ this.createWindow.title }}</template>
            <create-remain-price-component :store_id="this.store_id" :price_id="this.price_id"></create-remain-price-component>
        </customModal>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Toast from 'primevue/toast';
import ConfirmDialog from "primevue/confirmdialog";
import vTable from "@/components/admin/main/table/v-table.vue";
import customModal from "@/shared/ui/Modal.vue";
import CreateRemainPriceComponent from "@/components/admin/integration/store/remain/price/CreateComponent.vue";

export default {
    name: "ShowRemainPriceComponent",
    props: {
        store_id: {
            type: Number,
            default: 0,
        },
        remain_id: {
            type: Number,
            default: 0,
        },
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
            price_id: 0,
            createRemainPriceWindow: false,
            createWindow: {
                title: "",
            },
            createTitle: "Создать цену",
            updateTitle: "Редактировать цену",
            confirm: null,
            toast: null,
            remainPriceTable:{
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
                    guid: {
                        label: 'GUID',
                        type: 'text',
                    },
                    price: {
                        label: 'GUID родителя',
                        type: 'text',
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
            'getRemainPrices'
        ]),
        filter (data) {
            this.remainPriceTable.page = 1
            data.storeId = this.store_id
            data.remainId = this.remain_id
            this.getRemainPrices(data)
        },
        paginate (data) {
            this.remainPriceTable.page = data.page
            data.storeId = this.store_id
            data.remainId = this.remain_id
            this.getRemainPrices(data)
        },
        editElem(data){
            this.price_id = data.id
            this.createWindow.title = this.updateTitle
            this.createRemainPriceWindow = true
        },
        deleteElem (data) {
            // 1. Запрашиваем подтверждение
            this.$confirm.require({
                message: `Вы уверены, что хотите удалить цену - ${data.name}?`,
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
                    return this.$api.base.delete(`/api/integration/store/${this.store_id}/remain/${this.remain_id}/price/${data.id}`)
                        .then((response) => {
                            this.remainPriceTable.page = 1
                            this.getRemains({
                                storeId: this.store_id,
                                remainId: this.remain_id,
                                page: this.remainPriceTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            // console.log(error)
                            if (error.response.status === 404) {
                                this.remainPriceTable.page = 1
                                // this.$toast.add({ severity: 'error', summary: 'Не найден', detail: 'Объект не найден', life: 3000 });
                                this.getRemains({
                                    storeId: this.store_id,
                                    remainId: this.remain_id,
                                    page: this.remainPriceTable.page,
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
        this.getRemainPrices({
            storeId: this.store_id,
            remainId: this.remain_id,
            page: this.remainPriceTable.page,
            perpage: this.pagination_items_per_page
        })
    },
    components: {
        customModal,
        CreateRemainPriceComponent,
        vTable,
        Toast,
        ConfirmDialog
    },
    computed: {
        ...mapGetters([
            "remainPrices"
        ])
    },
    watch: {
    },
};
</script>

<style lang="scss">
.img_abs img{
    width: 50px;
    height: 50px;
    border-radius: 50%;
}
</style>

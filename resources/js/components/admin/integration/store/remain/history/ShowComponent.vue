<template>
    <div class="dart-container">
        <div class="dart-row">
            <div class="d-col-md-24">
                <v-table
                    class=""
                    :filters="this.remainHistoryTable.filters"
                    :items_data="remainHistories.data"
                    :total="remainHistories.total"
                    :pagination_items_per_page="this.pagination_items_per_page"
                    :pagination_offset="this.pagination_offset"
                    :page="this.remainHistoryTable.page"
                    :table_data="this.remainHistoryTable.table_data"
                    title="История изменения"
                    @filter="filter"
                    @sort="filter"
                    @paginate="paginate"
                    @deleteElem="deleteElem"
                    @editElem="editElem"
                >
                    <template v-slot:button>
                        <div class="dart-mb-1">
                            <button class="btn btn-primary" @click.prevent="() => { this.history_id = 0; this.createRemainHistoryWindow = true; this.createWindow.title = this.createTitle}"> Создать историю </button>
                        </div>
                    </template>
                </v-table>
            </div>
        </div>
        <customModal
            v-model="createRemainHistoryWindow"
            @cancel="cancel"
        >
            <template v-slot:title>{{ this.createWindow.title }}</template>
            <create-remain-history-component @close="close()" :store_id="this.store_id" :remain_id="this.remain_id" :history_id="this.history_id"></create-remain-history-component>
        </customModal>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Toast from 'primevue/toast';
import ConfirmDialog from "primevue/confirmdialog";
import vTable from "@/components/admin/main/table/v-table.vue";
import customModal from "@/shared/ui/Modal.vue";
import CreateRemainHistoryComponent from "@/components/admin/integration/store/remain/history/CreateComponent.vue";

export default {
    name: "ShowRemainHistoryComponent",
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
            history_id: 0,
            createRemainHistoryWindow: false,
            createWindow: {
                title: "",
            },
            createTitle: "Создать историю",
            updateTitle: "Редактировать историю",
            confirm: null,
            toast: null,
            remainHistoryTable:{
                page: 1,
                pagination_offset: 0,
                pagination_items_per_page: 24,
                filter: {},
                filters: {},
                table_data: {
                    id: {
                        label: "ID",
                        type: "text",
                    },
                    date: {
                        label: 'Дата',
                        type: 'text',
                    },
                    remains: {
                        label: 'Остаток',
                        type: 'text',
                    },
                    available: {
                        label: 'Доступно',
                        type: 'text',
                    },
                    reserved: {
                        label: 'Резерв',
                        type: 'text',
                    },
                    price: {
                        label: 'Цена',
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
            'getRemainHistories'
        ]),
        close(){
            this.createRemainHistoryWindow = false
            this.getRemainHistories({
                storeId: this.store_id,
                remainId: this.remain_id,
                page: this.remainHistoryTable.page,
                perpage: this.pagination_items_per_page
            })
        },
        filter (data) {
            this.remainHistoryTable.page = 1
            data.storeId = this.store_id
            data.remainId = this.remain_id
            this.getRemainHistories(data)
        },
        paginate (data) {
            this.remainHistoryTable.page = data.page
            data.storeId = this.store_id
            data.remainId = this.remain_id
            this.getRemainHistories(data)
        },
        editElem(data){
            this.history_id = data.id
            this.createWindow.title = this.updateTitle
            this.createRemainHistoryWindow = true
        },
        deleteElem (data) {
            // 1. Запрашиваем подтверждение
            this.$confirm.require({
                message: `Вы уверены, что хотите удалить запись Истории - ${data.id}?`,
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
                    return this.$api.base.delete(`/api/integration/store/${this.store_id}/remain/${this.remain_id}/history/${data.id}`)
                        .then((response) => {
                            this.remainHistoryTable.page = 1
                            this.getRemainHistories({
                                storeId: this.store_id,
                                remainId: this.remain_id,
                                page: this.remainHistoryTable.page,
                                perpage: this.pagination_items_per_page
                            })
                        })
                        .catch(error => {
                            // console.log(error)
                            if (error.response.status === 404) {
                                this.remainHistoryTable.page = 1
                                // this.$toast.add({ severity: 'error', summary: 'Не найден', detail: 'Объект не найден', life: 3000 });
                                this.getRemainHistories({
                                    storeId: this.store_id,
                                    remainId: this.remain_id,
                                    page: this.remainHistoryTable.page,
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
        this.getRemainHistories({
            storeId: this.store_id,
            remainId: this.remain_id,
            page: this.remainHistoryTable.page,
            perpage: this.pagination_items_per_page
        })
    },
    components: {
        customModal,
        CreateRemainHistoryComponent,
        vTable,
        Toast,
        ConfirmDialog
    },
    computed: {
        ...mapGetters([
            "remainHistories"
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

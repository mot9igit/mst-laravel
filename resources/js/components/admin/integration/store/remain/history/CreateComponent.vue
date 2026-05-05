<template>
    <div>
        <vForm
            :title="this.headerForm"
            :submit_text="this.submitText"
            method="post"
            :mode="this.mode"
            :form_url="this.formUrl"
            :form_data="this.formData"
            :form_values="this.form"
            @close="close()"
        >
            <template #header="{ title }">
                <div></div>
            </template>
            <template #footer="{ submit_text, loading }">
                <button class="btn btn-primary" type="button" disabled v-if="loading">
                    <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                    <span role="status">Загрузка...</span>
                </button>
                <button type="submit" class="btn btn-success" v-else>{{ submit_text? submit_text : 'Отправить' }}</button>
            </template>
        </vForm>
    </div>
</template>
<script>
import vForm from "@/components/admin/main/form/v-form.vue";
import {mapActions, mapGetters} from "vuex";

export default{
    name: "CreateRemainHistoryComponent",
    emits: [
        'close'
    ],
    props: {
        history_id: {
            type: Number,
            default: 0
        },
        store_id: {
            type: Number,
            default: 0
        },
        remain_id: {
            type: Number,
            default: 0
        },
    },
    data() {
        return {
            form: {},
        }
    },
    components: {
        vForm
    },
    mounted(){
        if(this.history_id > 0) {
            const reqData = {
                historyId: this.history_id,
                remainId: this.remain_id,
                storeId: this.store_id
            }
            this.getRemainHistory(reqData).then(() => {
                this.form.date = new Date(this.remainHistory.date);
                this.form.remains = this.remainHistory.remains;
                this.form.available = this.remainHistory.available;
                this.form.reserved = this.remainHistory.reserved;
                this.form.price = this.remainHistory.price;
                this.form.description = this.remainHistory.description;
            })
        }
        this.form.history_id = this.history_id
        this.form.remain_id = this.remain_id
        this.form.store_id = this.store_id
    },
    methods: {
        ...mapActions([
            'getRemainHistory'
        ]),
        close(){
            this.$emit('close')
        }
    },
    computed: {
        ...mapGetters([
            'remainHistory'
        ]),
        formUrl() {
            if (Number(this.history_id) > 0) {
                return `/api/integration/store/${this.store_id}/remain/${this.remain_id}/history/${this.history_id}`;
            } else {
                return `/api/integration/store/${this.store_id}/remain/${this.remain_id}/history/`;
            }
        },
        headerForm() {
            if (Number(this.history_id) > 0) {
                return 'Редактировать историю';
            } else {
                return 'Создать историю';
            }
        },
        submitText() {
            if(Number(this.history_id) > 0){
                return 'Редактировать историю';
            }else{
                return 'Создать историю';
            }
        },
        mode() {
            if(Number(this.history_id) > 0){
                return 'update';
            }else{
                return 'create';
            }
        },
        formData(){
            return [{
                grids: [{
                    class: "d-col-md-24",
                    fields: {
                        date: {
                            type: 'datetime',
                            label: "Дата",
                            value: new Date()
                        },
                        remains: {
                            type: 'number',
                            fractionDigits: 0,
                            suffix: ' шт',
                            label: "Остаток",
                            value: ''
                        },
                        available: {
                            type: 'number',
                            fractionDigits: 0,
                            suffix: ' шт',
                            label: "Доступно для продажи",
                            value: ''
                        },
                        reserved: {
                            type: 'number',
                            fractionDigits: 0,
                            suffix: ' шт',
                            label: "Резерв",
                            value: ''
                        },
                        price: {
                            type: 'number',
                            fractionDigits: 2,
                            suffix: ' ₽',
                            label: "Цена",
                            value: ''
                        },
                        description: {
                            type: 'textarea',
                            label: "Описание",
                            value: ''
                        }
                    }
                }]
            }];
        },
    }
}
</script>
<style lang="scss">

</style>

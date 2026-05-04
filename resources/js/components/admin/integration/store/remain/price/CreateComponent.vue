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
    name: "CreateRemainPriceComponent",
    props: {
        price_id: {
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
        if(this.price_id > 0) {
            const reqData = {
                priceId: this.price_id,
                remainId: this.remain_id,
                storeId: this.store_id
            }
            this.getRemainPrice(reqData).then(() => {
                this.form.name = this.remainPrice.name;
                this.form.description = this.remainPrice.description;
                this.form.guid = this.remainPrice.guid;
                this.form.price = this.remainPrice.price;
            })
        }
        this.form.price_id = this.price_id
        this.form.remain_id = this.remain_id
        this.form.store_id = this.store_id
    },
    methods: {
        ...mapActions([
            'getRemainPrice'
        ])
    },
    computed: {
        ...mapGetters([
            'remainPrice'
        ]),
        formUrl() {
            if (Number(this.price_id) > 0) {
                return `/api/integration/store/${this.store_id}/remain/${this.remain_id}/price/${this.price_id}`;
            } else {
                return `/api/integration/store/${this.store_id}/remain/${this.remain_id}/price/`;
            }
        },
        headerForm() {
            if (Number(this.price_id) > 0) {
                return 'Редактировать цену';
            } else {
                return 'Создать цену';
            }
        },
        submitText() {
            if(Number(this.price_id) > 0){
                return 'Редактировать цену';
            }else{
                return 'Создать цену';
            }
        },
        mode() {
            if(Number(this.price_id) > 0){
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
                        name: {
                            type: 'text',
                            label: "Наименование",
                            value: ''
                        },
                        guid: {
                            type: 'text',
                            label: "GUID",
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

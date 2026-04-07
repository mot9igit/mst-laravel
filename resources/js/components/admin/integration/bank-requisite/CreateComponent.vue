<template>
    <div>
        <vForm v-if="this.bank_requisite_id == 0"
            :title="this.headerForm"
            :submit_text="this.submitText"
            method="post"
            :mode="this.mode"
            :form_url="this.formUrl"
            :redirect_url="'/adm/organization/' + this.org_id + '/requisite/' + this.requisite_id"
            :form_data="this.formData"
            :form_values="this.form"
        />
        <vForm v-else
               :title="this.headerForm"
               :submit_text="this.submitText"
               method="post"
               :mode="this.mode"
               :form_url="this.formUrl"
               :redirect_url="'/adm/organization/' + this.org_id + '/requisite/' + this.requisite_id"
               :form_data="this.formData"
               :form_values="this.form"
        >
        </vForm>
    </div>
</template>

<script>
import vForm from '../../main/form/v-form.vue';
import {mapActions, mapGetters} from "vuex";
import Dropzone from "dropzone";

export default {
    name: "CreateBankRequisiteComponent",
    props: {
        org_id: {
            type: Number,
            default: 0
        },
        requisite_id: {
            type: Number,
            default: 0
        },
        bank_requisite_id: {
            type: Number,
            default: 0
        }
    },
    components: {
        vForm
    },
    data() {
        return {
            form: {},
        }
    },
    mounted(){
        if(this.bank_requisite_id > 0) {
            const reqData = {
                bank_requisite_id: this.bank_requisite_id,
                requisite_id: this.requisite_id,
                org_id: this.org_id
            }
            this.getBankRequisite(reqData).then(() => {
                this.form.name = this.bankRequisite.name;
                this.form.bik = this.bankRequisite.bik;
                this.form.number = this.bankRequisite.number;
                this.form.knumber = this.bankRequisite.knumber;
                this.form.description = this.bankRequisite.description;
            })
        }
        this.form.org_id = this.org_id
        this.form.requisite_id = this.requisite_id
    },
    methods: {
        ...mapActions([
            'getBankRequisite'
        ])
    },
    computed: {
        ...mapGetters([
            'bankRequisite'
        ]),
        formUrl(){
            if (Number(this.bank_requisite_id) > 0) {
                return '/api/integration/bank-requisite/' + this.bank_requisite_id;
            } else {
                return '/api/integration/bank-requisite/';
            }
        },
        headerForm() {
            if (Number(this.bank_requisite_id) > 0) {
                return 'Редактировать банковские реквизиты';
            } else {
                return 'Создать банковские реквизиты';
            }
        },
        submitText(){
            if(Number(this.bank_requisite_id) > 0){
                return 'Редактировать реквизиты';
            }else{
                return 'Создать реквизиты';
            }
        },
        mode(){
            if(Number(this.bank_requisite_id) > 0){
                return 'update';
            }else{
                return 'create';
            }
        },
        formData(){
            return [{
                grids: [{
                    class: "d-col-md-12",
                    fields: {
                        name: {
                            type: 'text',
                            label: "Наименование",
                            value: ''
                        },
                        bik: {
                            type: 'text',
                            value: '',
                            label: "БИК"
                        },
                        number: {
                            type: 'text',
                            value: '',
                            label: "Р/С"
                        },
                        knumber: {
                            type: 'text',
                            value: '',
                            label: "К/С"
                        }
                    }
                }]
            }];
        }
    }
}
</script>

<style scoped>

</style>

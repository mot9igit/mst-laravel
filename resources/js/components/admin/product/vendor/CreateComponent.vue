<template>
    <div>
        <vForm
            :title="this.headerForm"
            :submit_text="this.submitText"
            method="post"
            :mode="this.mode"
            :form_url="this.formUrl"
            redirect_url="/adm/product/vendor"
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
    name: "CreateVendorComponent",
    props: {
        vendor_id: {
            type: Number,
            default: 0
        }
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
        if(this.vendor_id > 0) {
            const reqData = {
                vendorId: this.vendor_id
            }
            this.getVendor(reqData).then(() => {
                this.form.name = this.vendor.name;
                this.form.description = this.vendor.description;
                this.form.thumb_url = this.vendor.thumb_url;
            })
        }
        this.form.vendor_id = this.vendor_id
    },
    methods: {
        ...mapActions([
            'getVendor'
        ])
    },
    computed: {
        ...mapGetters([
            'vendor'
        ]),
        formUrl() {
            if (Number(this.vendor_id) > 0) {
                return '/api/product/vendor/' + this.vendor_id;
            } else {
                return '/api/product/vendor/';
            }
        },
        headerForm() {
            if (Number(this.vendor_id) > 0) {
                return 'Редактировать бренд';
            } else {
                return 'Создать бренд';
            }
        },
        submitText() {
            if(Number(this.vendor_id) > 0){
                return 'Редактировать бренд';
            }else{
                return 'Создать бренд';
            }
        },
        mode() {
            if(Number(this.vendor_id) > 0){
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
                        image: {
                            type: 'image',
                            value: '',
                            defaultValue: 'thumb_url',
                            label: "Изображение"
                        },
                        description: {
                            type: 'textarea',
                            value: '',
                            label: "Описание"
                        },
                    }
                }]
            }];
        },
    }
}
</script>
<style lang="scss">

</style>

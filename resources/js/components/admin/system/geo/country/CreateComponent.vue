<template>
    <div>
        <vForm
            :title="this.headerForm"
            :submit_text="this.submitText"
            method="post"
            :mode="this.mode"
            :form_url="this.formUrl"
            redirect_url="/adm/system/geo"
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
    name: "CreateCountryComponent",
    props: {
        country_id: {
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
        if(this.country_id > 0) {
            const reqData = {
                countryId: this.country_id
            }
            this.getCountry(reqData).then(() => {
                this.form.name = this.country.name;
                this.form.key = this.country.key;
                this.form.population = this.country.population;
                this.form.active = Boolean(this.country.active);
            })
        }
        this.form.country_id = this.country_id
    },
    methods: {
        ...mapActions([
            'getCountry'
        ])
    },
    computed: {
        ...mapGetters([
            'country'
        ]),
        formUrl() {
            if (Number(this.country_id) > 0) {
                return '/api/system/geo/country/' + this.country_id;
            } else {
                return '/api/system/geo/country/';
            }
        },
        headerForm() {
            if (Number(this.country_id) > 0) {
                return 'Редактировать страну';
            } else {
                return 'Создать страну';
            }
        },
        submitText() {
            if(Number(this.country_id) > 0){
                return 'Редактировать страну';
            }else{
                return 'Создать страну';
            }
        },
        mode() {
            if(Number(this.country_id) > 0){
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
                        key: {
                            type: 'text',
                            label: "Ключ",
                            value: ''
                        },
                        population: {
                            type: 'text',
                            label: "Население",
                            value: ''
                        },
                        active: {
                            type: 'checkbox',
                            label: "Активна",
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

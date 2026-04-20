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
    name: "CreateCityComponent",
    props: {
        city_id: {
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
        if(this.city_id > 0) {
            const reqData = {
                cityId: this.city_id
            }
            this.getCity(reqData).then(() => {
                this.form.name = this.city.name;
                this.form.name_r = this.city.name_r;
                this.form.fias_id = this.city.fias_id;
                this.form.postal_code = this.city.postal_code;
                this.form.region_id = this.city.region;
                this.form.key = this.city.key;
                this.form.population = this.city.population;
                this.form.active = Boolean(this.city.active);
            })
        }
        this.form.city_id = this.city_id
    },
    methods: {
        ...mapActions([
            'getCity'
        ])
    },
    computed: {
        ...mapGetters([
            'city'
        ]),
        formUrl() {
            if (Number(this.city_id) > 0) {
                return '/api/system/geo/city/' + this.city_id;
            } else {
                return '/api/system/geo/city/';
            }
        },
        headerForm() {
            if (Number(this.city_id) > 0) {
                return 'Редактировать город';
            } else {
                return 'Создать город';
            }
        },
        submitText() {
            if(Number(this.city_id) > 0){
                return 'Редактировать город';
            }else{
                return 'Создать город';
            }
        },
        mode() {
            if(Number(this.city_id) > 0){
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
                        region_id: {
                            type: 'autocomplete',
                            label: "Регион",
                            value: '',
                            dropdown: true,
                            optionLabel: 'name',
                            searchType: 'custom',
                            searchUrl: `/api/system/geo/region/`
                        },
                        name_r: {
                            type: 'text',
                            label: "Наименование в род падеже",
                            value: ''
                        },
                        key: {
                            type: 'text',
                            label: "Ключ",
                            value: ''
                        },
                        fias_id: {
                            type: 'text',
                            label: "ФИАС код",
                            value: ''
                        },
                        postal_code: {
                            type: 'text',
                            label: "Индекс",
                            value: ''
                        },
                        population: {
                            type: 'text',
                            label: "Население",
                            value: ''
                        },
                        active: {
                            type: 'checkbox',
                            label: "Активен",
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

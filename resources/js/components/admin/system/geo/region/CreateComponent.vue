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
    name: "CreateRegionComponent",
    props: {
        region_id: {
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
        if(this.region_id > 0) {
            const reqData = {
                regionId: this.region_id
            }
            this.getRegion(reqData).then(() => {
                this.form.name = this.region.name;
                this.form.name_r = this.region.name_r;
                this.form.code = this.region.code;
                this.form.fias_id = this.region.fias_id;
                this.form.postal_code = this.region.postal_code;
                this.form.country_id = this.region.country;
                this.form.key = this.region.key;
                this.form.population = this.region.population;
                this.form.active = Boolean(this.region.active);
            })
        }
        this.form.region_id = this.region_id
    },
    methods: {
        ...mapActions([
            'getRegion'
        ])
    },
    computed: {
        ...mapGetters([
            'region'
        ]),
        formUrl() {
            if (Number(this.region_id) > 0) {
                return '/api/system/geo/region/' + this.region_id;
            } else {
                return '/api/system/geo/region/';
            }
        },
        headerForm() {
            if (Number(this.region_id) > 0) {
                return 'Редактировать регион';
            } else {
                return 'Создать регион';
            }
        },
        submitText() {
            if(Number(this.region_id) > 0){
                return 'Редактировать регион';
            }else{
                return 'Создать регион';
            }
        },
        mode() {
            if(Number(this.region_id) > 0){
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
                        country_id: {
                            type: 'autocomplete',
                            label: "Страна",
                            value: '',
                            dropdown: true,
                            optionLabel: 'name',
                            searchType: 'custom',
                            searchUrl: `/api/system/geo/country/`
                        },
                        name_r: {
                            type: 'text',
                            label: "Наименование в род падеже",
                            value: ''
                        },
                        code: {
                            type: 'text',
                            label: "Код",
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

<script>
import FloatLabel from "primevue/floatlabel";
import InputText from "primevue/inputtext";
import Textarea from "primevue/textarea";
import InputGroup from 'primevue/inputgroup';
import InputGroupAddon from "primevue/inputgroupaddon";
import Select from "primevue/select";
import Checkbox from "primevue/checkbox";

export default {
    name: "CreateApiKeyComponent",
    props: {
        org_id: {
            type: Number,
            default: 0
        },
    },
    components: {
        FloatLabel,
        InputText,
        Textarea,
        InputGroup,
        InputGroupAddon,
        Select,
        Checkbox,
    },
    data() {
        return {
            formData: {
                key: '',
                org_id: this.org_id,
                store_id: null,
                description: '',
                active: true,
            },
            loading: false,
            stores: []
        }
    },
    methods: {
        async handleSubmit() {
            this.loading = true;
            const redirect_url = `/adm/organization/${this.org_id}`;
            this.$api.base.post('/api/integration/api-key', this.formData)
                .then(res => {
                    if(redirect_url){
                        window.location.href = redirect_url;
                    }
                })
                .catch((error) => {
                    if(error.response?.data?.errors){
                        this.errors = error.response?.data?.errors
                    }
                    // this.$toast.add({ severity: 'error', summary: "Ошибка!", detail: error.response?.data?.message, life: 5000 });
                    this.loading = false
                });
            this.loading = false
        },
        async handleGenerateKey() {
            this.loading = true;
            const res = await fetch('/api/integration/api-key/generate', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                },
            });
            if(res.ok) {
                const data = await res.json();
                this.formData.key = data.key;
            }
            this.loading = false;
        },
        async getStores() {
            const res = await fetch('/api/integration/store');
            if(res.ok) {
                const data = await res.json();
                this.stores = data.data;
            }
        }
    },
    mounted() {
        this.getStores();
    },
    computed: {
        formUrl() {
            return `/api/integration/api-key`;
        },
        headerForm() {
            return 'Создать API ключ';
        },
        submitText() {
            return 'Создать API ключ';
        },
        mode() {
            return 'create';
        },
    }
}
</script>


<template>
    <div>
        <form @submit.prevent="handleSubmit" class="form">
            <FloatLabel variant="on" class="position-relative">
                <InputGroup>
                    <InputGroupAddon @click="handleGenerateKey" style="cursor: pointer">
                        <i class="bi bi-key"></i>
                    </InputGroupAddon>
                    <InputText placeholder="Ключ" v-model="formData.key" />
                </InputGroup>
                <label>Сгенерировать</label>
            </FloatLabel>

            <FloatLabel variant="on">
                <InputGroup>
                    <Select optionLabel="name" :options="stores" optionValue="id" v-model="formData.store_id"/>
                </InputGroup>
                <label>Точка продажи</label>
            </FloatLabel>

            <FloatLabel variant="on">
                <Textarea class="p-inputtext p-component" v-model="formData.description" id="description" autocomplete="off" style="resize: none"/>
                <label>Описание</label>
            </FloatLabel>

            <div class="flex items-center gap-2">
                <Checkbox v-model="formData.active" inputId="active" name="active" binary/>
                <label for="ingredient1"> Активный </label>
            </div>

            <div class="card-footer">
                <button class="btn btn-primary" type="button" disabled v-if="loading">
                    <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                    <span role="status">Загрузка...</span>
                </button>
                <button type="submit" class="btn btn-success" v-else>Создать ключ</button>
            </div>
        </form>
    </div>
</template>

<style lang="scss">
    .form {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

</style>

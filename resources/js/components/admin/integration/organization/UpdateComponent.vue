<template>
    <div>
        <Tabs value="0" scrollable>
            <TabList>
                <Tab value="0">
                    Организация
                </Tab>
                <Tab value="1">
                    Реквизиты
                </Tab>
                <Tab value="2">
                    Контактные лица
                </Tab>
                <Tab value="3">
                    Точки продаж
                </Tab>
                <Tab value="4">
                    Пользователи
                </Tab>
                <Tab value="5">
                    Бренды
                </Tab>
                <Tab value="6">
                    Ключи API
                </Tab>
            </TabList>
            <TabPanels>
                <TabPanel value="0">
                    <create-organization-component :orgid="this.orgid"></create-organization-component>
                </TabPanel>
                <TabPanel value="1">
                    <show-requisite-component :org_id="this.orgid"></show-requisite-component>
                </TabPanel>
                <TabPanel value="2">
                    <show-organization-contact-person-component :org_id="this.orgid"></show-organization-contact-person-component>
                </TabPanel>
                <TabPanel value="3">
                    <show-organization-stores-component :org_id="this.orgid"></show-organization-stores-component>
                </TabPanel>
                <TabPanel value="4">
                    <show-organization-users-component :org_id="this.orgid"></show-organization-users-component>
                </TabPanel>
                <TabPanel value="5">
                    <show-organization-vendors-component :org_id="this.orgid"></show-organization-vendors-component>
                </TabPanel>
                <TabPanel value="6">
                    <show-api-key-component :org_id="this.orgid"></show-api-key-component>
                </TabPanel>
            </TabPanels>
        </Tabs>
    </div>
</template>

<script>
import Tabs from 'primevue/tabs';
import TabList from 'primevue/tablist';
import Tab from 'primevue/tab';
import TabPanels from 'primevue/tabpanels';
import TabPanel from 'primevue/tabpanel';
import ShowOrganizationUsersComponent from "../user/ShowOrganizationUsersComponent.vue";
import ShowOrganizationStoresComponent from "../store/ShowOrganizationStoresComponent.vue";
import ShowOrganizationVendorsComponent from "../vendor/ShowOrganizationVendorsComponent.vue";
import ShowOrganizationContactPersonComponent from "../contact-person/ShowComponent.vue";
import ShowApiKeyComponent from "../api-key/ShowComponent.vue";
export default{
    name: "UpdateOrganizationComponent",
    components: {
        ShowApiKeyComponent,
        ShowOrganizationContactPersonComponent,
        Tabs,
        TabList,
        Tab,
        TabPanels,
        TabPanel,
        ShowOrganizationUsersComponent,
        ShowOrganizationStoresComponent,
        ShowOrganizationVendorsComponent
    },
    props: {
        orgid: {
            type: Number,
            default: 0
        }
    }
}
</script>
<style scoped lang="scss">

</style>

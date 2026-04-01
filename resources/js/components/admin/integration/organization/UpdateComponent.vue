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
                    <p class="m-0">Реквизиты</p>
                </TabPanel>
                <TabPanel value="2">
                    <p class="m-0">Контактные лица</p>
                </TabPanel>
                <TabPanel value="3">
                    <p class="m-0">Точки продаж</p>
                </TabPanel>
                <TabPanel value="4">
                    <p class="m-0">Пользователи</p>
                </TabPanel>
                <TabPanel value="5">
                    <p class="m-0">Бренды</p>
                </TabPanel>
                <TabPanel value="6">
                    <p class="m-0">Ключи API</p>
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
export default{
    name: "UpdateOrganizationComponent",
    components: {
        Tabs,
        TabList,
        Tab,
        TabPanels,
        TabPanel
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

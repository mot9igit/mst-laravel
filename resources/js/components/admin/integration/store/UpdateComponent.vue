<template>
    <div>
        <Tabs value="0" scrollable>
            <TabList>
                <Tab value="0">
                    Точка продаж
                </Tab>
                <Tab value="1">
                    Остатки
                </Tab>
                <Tab value="2">
                    Документы
                </Tab>
            </TabList>
            <TabPanels>
                <TabPanel value="0">
                    <create-store-component :store_id="this.store_id"></create-store-component>
                </TabPanel>
                <TabPanel value="1">
                    <p>Остатки</p>
                </TabPanel>
                <TabPanel value="2">
                    <p>Документы</p>
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
    name: "UpdateStoreComponent",
    components: {
        Tabs,
        TabList,
        Tab,
        TabPanels,
        TabPanel
    },
    props: {
        store_id: {
            type: Number,
            default: 0
        }
    }
}
</script>
<style scoped lang="scss">

</style>

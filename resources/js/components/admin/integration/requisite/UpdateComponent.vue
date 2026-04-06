<template>
    <div>
        <Tabs value="0" scrollable>
            <TabList>
                <Tab value="0">
                    Реквизиты
                </Tab>
                <Tab value="1">
                    Банковские реквизиты
                </Tab>
            </TabList>
            <TabPanels>
                <TabPanel value="0">
                    <create-organization-requisite-component :org_id="this.org_id" :requisite_id="this.requisite_id"></create-organization-requisite-component>
                </TabPanel>
                <TabPanel value="1">
                    <p>Тут банковские реквизиты</p>
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
    name: "UpdateOrganizationRequisiteComponent",
    components: {
        Tabs,
        TabList,
        Tab,
        TabPanels,
        TabPanel
    },
    props: {
        org_id: {
            type: Number,
            default: 0
        },
        requisite_id: {
            type: Number,
            default: 0
        }
    }
}
</script>
<style scoped lang="scss">

</style>

<template lang="">
    <Head title="Schools"/>
    <PageHeader title="Schools" pageTitle="Menu" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-sidebar">
            <Sidebar :statistics="statistics.statistics"/>
        </div>
        <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(100vh - 180px); overflow: auto;" ref="box">
            <Lists />
        </div>
    </div>
</template>
<script>
import Sidebar from './Components/Sidebar.vue';
import Lists from './Components/Lists.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    components: { PageHeader, Lists, Sidebar },
    props: ['statistics']
}
</script>
<template lang="">
    <Head title="Monitoring"/>
    <PageHeader title="Monitoring" pageTitle="Menu" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-sidebar">
            <div class="p-4 d-flex flex-column h-100 file-detail-content-scroll" style="overflow: auto;">
                <Left :left="statistics.left"/>
            </div>
         </div>
        <div class="file-manager-content p-3 pb-0 w-100" ref="myDiv">
            <Middle :settings="settings" :dropdowns="dropdowns" :terms="statistics.middle.terms"/>
        </div>
        <div class="file-manager-sidebar">
            <div class="p-4 d-flex flex-column h-100 file-detail-content-scroll" data-simplebar>
               <Right :right="statistics.right"/>
            </div>
         </div>
    </div>
</template>
<script>
import Left from './Pages/Left/Index.vue';
import Right from './Pages/Right/Index.vue';
import Middle from './Pages/Middle/Index.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    components: { PageHeader, Left, Right, Middle },
    props: ['statistics','dropdowns'],
    data() {
        return {
            currentUrl: window.location.origin
        };
    },
}
</script>
<style>
.file-manager-sidebar {
    min-width: 450px;
    max-width: 450px;
    height: calc(100vh - 180px);
}
</style>
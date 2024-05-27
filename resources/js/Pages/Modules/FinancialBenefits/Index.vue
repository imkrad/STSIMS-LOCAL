<template lang="">
    <Head title="Financial Benefits"/>
    <PageHeader title="Financial Benefits" pageTitle="Menu" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-sidebar">
            <Sidebar :latest="latest" ref="sidebar"/>
        </div>
        <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(100vh - 180px); overflow: auto;" ref="box">
            <Lists :privileges="privileges" v-if="show == 'default'" ref="lists"/>
            <Generate :latest="latest" v-else ref="generate"/>
        </div>
    </div>
</template>
<script>
import Lists from './Components/Lists.vue';
import Sidebar from './Components/Sidebar.vue';
import Generate from './Components/Generate.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    components: { PageHeader, Lists, Sidebar, Generate },
    props: ['latest','privileges'],
    data(){
        return {
            currentUrl: window.location.origin,
            show: 'default',
        }
    },
    mounted(){
        this.$refs.sidebar.set(this.latest);
    },
    methods: {
        showPage(data){
            this.show = data;
            (data == 'generate') ?  this.$nextTick(function(){this.$refs.generate.fetch()}) : '';
        },
        showList(){
            this.show = 'default';
            this.$refs.sidebar.set(this.latest);
        }
    }
}
</script>
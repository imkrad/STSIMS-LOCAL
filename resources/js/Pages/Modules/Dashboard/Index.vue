<template lang="">
    <Head title="Dashboard"/>
    <PageHeader title="Dashboard" pageTitle="Menu" />
        <b-row style="height: calc(100vh - 225px); overflow: auto;">
            
        </b-row>
</template>
<script>
import PageHeader from '@/Shared/Components/PageHeader.vue';
export default {
    components: { PageHeader },
    data(){
        return {
            currentUrl: window.location.origin,
        }
    }
}
</script>
<template lang="">
    <Head title="Insights"/>
    <PageHeader title="Insights" pageTitle="Menu" />
    <b-row style="height: calc(100vh - 225px); overflow: auto;">
        <b-col xxl="4">
            <Total :scholars="statistics.scholars" ref="total"/>
        </b-col>
        <b-col xxl="8" order-xxl="0" class="order-first">
            <Count :statistics="statistics.countings" ref="count"/>
        </b-col>
        <b-col xxl="4">
            <Gender/>
        </b-col>
        <b-col xxl="8">
            <Years ref="years"/>
        </b-col>
        <b-col xxl="6">
            <School :total="statistics.scholars.total" ref="school"/>
        </b-col>
        <b-col xxl="6">
            <Course :total="statistics.scholars.total" ref="course"/>
        </b-col>
        <b-col xxl="6">
            <Province :provinces="statistics.provinces" ref="provinces"/>
        </b-col>
        <b-col xxl="6">
            <Status :statuses="statistics.statuses"/>
        </b-col>
    </b-row>
</template>
<script>
import Years from './Components/Years.vue';
import Total from './Components/Total.vue';
import Count from './Components/Count.vue';
import School from './Components/School.vue';
import Course from './Components/Course.vue';
import Gender from './Components/Gender.vue';
import Status from './Components/Status.vue';
import Province from './Components/Province.vue';
import PageHeader from "@/Shared/Components/PageHeader.vue";
export default {
    components : { PageHeader, Total, Count, Province, Years, School, Course, Gender, Status },
    props: ['statistics'],
    data(){
        return {
            currentUrl: window.location.origin
        }
    }
}
</script>
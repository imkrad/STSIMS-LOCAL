<template>
    <Head :title="school.data.name" />
    <Top :school="school"/>
     <b-row class="g-3">
       <Sidebar :id="school.data.id" :active="active.data"/>
        <b-col lg="8">
            <b-row>
                <Count :counts="counts" :school="school"/>
                <b-col lg="12 mt-n2">
                    <b-card no-body>
                        <b-card-body style="height: calc(100vh - 385px); overflow: auto;">
                            <BTabs nav-class="nav-pills nav-custom nav-custom-light" pills small>
                                <BTab title="Overview">
                                    Overview
                                </BTab>
                                <BTab title="Courses">
                                    <Course :id="school.data.id" :term="school.data.term"/>
                                </BTab>
                                <BTab title="Semesters">
                                    <Semester />
                                </BTab>
                                <BTab title="Grading">
                                    <Grading />
                                </BTab>
                            </BTabs>
                        </b-card-body>
                    </b-card>
                </b-col>
            </b-row>
       </b-col>
    </b-row>
</template>
<script>
import Top from './Top.vue';
import Sidebar from './Sidebar.vue';
import Count from './Count.vue';
import Course from './Pages/Course/Index.vue';
import Semester from './Pages/Semester/Index.vue';
import Grading from './Pages/Grading/Index.vue';
export default {
    props: ['school','active','terms','counts'],
    components: { Top, Sidebar, Count, Course, Semester, Grading }
}
</script>
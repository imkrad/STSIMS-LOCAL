<template>
    <b-modal v-model="showModal" hide-footer class="v-modal-custom" modal-class="zoomIn" fullscreen>
        <template v-slot:header>
            <div style="border-bottom: 1px solid #ccc; width: 100%;">
                <i @click="showModal=false" class="ri-close-circle-fill float-end" style="cursor:pointer; font-size: 40px; margin-top: -10px;"></i>
                <b-row class="mb-3 mt-n1">
                    <b-col md>
                        <b-row class="align-items-center g-3">
                            <b-col md>
                                <div>
                                    <h5 class="fw-semibold">{{selected.course}}</h5>
                                    <div class="hstack gap-3 flex-wrap">
                                        <div class="text-muted">Scholars :
                                            <span class="text-body fw-medium">{{selected.scholars}}</span>
                                        </div>
                                        <div class="vr"></div>
                                        <div class="text-muted">Certification : 
                                            <span class="text-body fw-medium">{{selected.certification}}</span>
                                        </div>
                                        <div class="vr"></div>
                                        <div class="text-muted">Validity : 
                                            <span class="text-body fw-medium">{{selected.validity}}</span>
                                        </div>
                                        <div class="vr"></div>
                                        <div class="text-muted">Years : 
                                            <span class="text-body fw-medium">{{selected.years}}</span>
                                        </div>
                                    </div>
                                </div>
                            </b-col>
                        </b-row>
                    </b-col>
                </b-row>
            </div>
        </template>
        <div class="row">
            <div class="col-md-3">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr style="">
                            <td >
                                <!-- <button  @click="openNew(selected)" class="btn btn-light btn-sm btn-label mt-n1 float-end" type="button">
                                    <div class="btn-content"><i class="ri-add-circle-fill label-icon align-middle fs-12 me-2"></i>New</div>
                                </button> -->
                                <span class="fw-semibold">LIST OF PROSPECTUS</span>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(list, index) of selected.prospectuses" :key="index">
                            <td style="cursor: pointer;">Academic Year {{ list.school_year}}
                                <span v-if="list.is_active" class="badge bg-success float-end">Active</span>
                                <span v-else class="badge bg-danger float-end">Inactive</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr style="">
                                    <td >
                                        <span class="fw-semibold">Academic Year {{prospectus.school_year}}</span>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <b-tabs v-model="tabIndex">
                        <b-tab v-for="(semester,index) in semesters" v-bind:key="index">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0"> 
                                    <thead>
                                        <tr class="text-center text-primary font-weight-bold font-size-12">
                                            <th colspan="2" class="bg-primary">
                                                <a class="bx-tada float-start text-white" @click="nxtBtn('back')"><i class='bx bx-chevrons-left' ></i></a>
                                                <span class="text-white">{{semester.year_level}}</span>
                                                <a class="bx-tada float-end text-white" @click="nxtBtn('next')"><i class='bx bx-chevrons-right'></i></a>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                                <b-tabs v-model="tabIndex2">
                                    <b-tab v-for="(s,index2) in semester.semesters" v-bind:key="index2">
                                        <table class="table table-bordered mb-0"> 
                                            <thead>
                                                <tr class="text-center text-danger font-weight-bold font-size-12">
                                                    <th colspan="2" class="bg-dark-subtle">
                                                        <a class="bx-tada float-start" @click="tabIndex2--"><i class='bx bx-chevrons-left' ></i></a>
                                                        <span class="mt-2">{{s.semester}} </span>
                                                        <a class="bx-tada float-end" @click="tabIndex2++"><i class='bx bx-chevrons-right'></i></a>
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <div style="height: calc(100vh - 350px); overflow: auto;">
                                            <table class="table table-borderless align-middle">
                                                <tbody>
                                                    <tr v-for="(course, index3) in s.courses" v-bind:key="'a-'+index3" class="mb-n4" style="display: block;">
                                                        <td width="12%">
                                                            <div class="form-check">
                                                                <input class="form-check-input" v-model="course.is_lab" type="checkbox" id="formCheck1">
                                                                <label class="form-check-label fs-12" for="formCheck1">&nbsp;&nbsp;Is Laboratory?</label>
                                                            </div>
                                                        </td>
                                                        <td width="14%">
                                                            <div class="form-check">
                                                                <input class="form-check-input" v-model="course.is_nonacademic" type="checkbox" id="formCheck2">
                                                                <label class="form-check-label fs-12" for="formCheck2">&nbsp;&nbsp;Is Non-Academic?</label> 
                                                            </div>                                                           
                                                        </td>
                                                        <td width="12%">
                                                            <input type="text" class="form-control" v-model="course.code" placeholder="Course code" style="text-transform: capitalize;" required>
                                                        </td>
                                                        <td width="52%">
                                                            <input type="text" class="form-control" v-model="course.subject" placeholder="Course/Subject" style="text-transform: capitalize;" required>
                                                        </td>
                                                        <td width="5%">
                                                            <input type="text" class="form-control" v-model="course.unit" placeholder="Unit" style="text-transform: capitalize;" required>
                                                        </td>
                                                        <td class="text-end" width="2%">
                                                            <b-button @click="rmvBtn(index,index2,index3)" variant="soft-danger" v-b-tooltip.hover title="Remove" class="edit-list"><i class="ri-delete-bin-5-line align-bottom"></i> </b-button>
                                                        </td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                        <table class="table table-bordered mb-0">
                                            <tbody>
                                                <tr class="bg-opacity-10">
                                                    <td>
                                                        <button @click="addBtn(index,index2)" class="btn btn-secondary btn-md btn-label me-1" type="button">
                                                            <div class="btn-content"><i class="ri-add-circle-fill label-icon align-middle fs-16 me-2"></i> Add Subject </div>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <span class="float-end font-size-11 fw-bold mt-2 me-2">Total Units: {{ totalUnits(s.courses) }}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </b-tab>
                                </b-tabs>
                            </div>
                        </b-tab>
                    </b-tabs>
                </div>
            </div>
        </div>
    </b-modal>
    <Prospectus :term="term" @new="addNew" ref="prospectus"/>
</template>
<script>
import Prospectus from './Modals/Prospectus.vue';
export default {
    components: { Prospectus },
    props: ['term'],
    data(){
        return {
            selected: {
                course: {}, prospectuses: {}
            },
            prospectus: {},
            semesters: [],
            form: this.$inertia.form({
                id: '',
                subjects: '',
                editable: true,
                type: 'prospectus'
            }),
            index: null,
            tabIndex: 0,
            tabIndex2: 0,
            showModal: false
        }
    },
    methods: {
        show(data){
            this.selected = data;
            if(this.selected.prospectuses.length > 0){
                this.openProspectus(this.selected.prospectuses[0],0)
            }
            this.showModal = true;
        },
        openProspectus(prospectus,index){
            this.index = index;
            this.prospectus = prospectus;
            if(typeof this.prospectus.subjects === 'string'){
                this.semesters = JSON.parse(this.prospectus.subjects);
            }else{
                this.semesters = this.prospectus.subjects;
            }
        },
        openNew(data){
            this.$refs.prospectus.show(data);
        },
        addNew(){
            this.selected.prospectuses.unshift(this.$page.props.flash.data);
        },
        nxtBtn(type){
            (type == 'next') ? this.tabIndex++ : this.tabIndex--;
            this.tabIndex2 = 0;
        },
        addBtn(one,two){
            this.semesters[one].semesters[two].courses.push({code: '',subject: '',unit: '',is_lab: false,is_nonacademic: false})
        },
        rmvBtn(one,two,three){
            this.semesters[one].semesters[two].courses.splice(three,1);
        },
        totalUnits(lists){
            var sum = 0;
            if(lists != undefined){
                lists.forEach(e => {
                    sum += Number(e.unit);
                });
            }
            return sum
        },
        hide(){
            this.showModal = false;
        }
    }
}
</script>
<style>
td input {
    text-align: center;
}
</style>

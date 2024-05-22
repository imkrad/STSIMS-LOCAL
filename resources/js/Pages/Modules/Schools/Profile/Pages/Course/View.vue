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
            <div class="col-md-3 mt-n3">
                <table class="table table-bordered">
                    <tbody>
                        <tr style="border-top: none;">
                            <td style="border-left: none; border-top: none;">
                                <button  @click="openNew(selected)" class="btn btn-light btn-sm btn-label mt-n1 float-end" type="button">
                                    <div class="btn-content"><i class="ri-add-circle-fill label-icon align-middle fs-12 me-2"></i>New</div>
                                </button>
                                <span class="fw-semibold fs-12">List of Prospectus</span>
                            </td>
                        </tr>
                        <tr v-for="(list, index) of selected.prospectuses" :key="index">
                            <td>{{ list.school_year}} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </b-modal>
    <Prospectus :term="term" ref="prospectus"/>
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
            index: null,
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
        hide(){
            this.showModal = false;
        }
    }
}
</script>
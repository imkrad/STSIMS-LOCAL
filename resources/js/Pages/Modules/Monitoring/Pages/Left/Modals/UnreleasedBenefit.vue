<template>
     <b-modal v-model="showModal" title="Unreleased Benefits" :hide-footer="(viewScholar) ? false : true" style="--vz-modal-width: 900px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered>    
        <template v-if="!viewScholar">
            <input class="form-control mb-3" v-model="filter.keyword" type="text" placeholder="Search Scholar">
            <hr class="text-muted"/>
            <div class="table-responsive">
                <table class="table table-bordered table-nowrap align-middle mb-0">
                    <thead class="table-light">
                        <tr class="fs-11">
                            <th width="7%" class="text-center">#</th>
                            <th width="50%">Name</th>
                            <th width="15%" class="text-center">No. of enrollments</th>
                            <th width="30%" class="text-center">Total</th>
                            <th width="5%" class="text-center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(list,index) in lists" v-bind:key="list.id" class="fs-11">
                            <td class="text-center">{{index + 1}}</td>
                            <td>
                                <h5 class="fs-12 mb-0 text-dark">{{ list.firstname }} {{ list.lastname }}</h5>
                                <p class="text-muted fs-11 mb-n1">{{ list.spas_id }}</p>
                            </td>
                            <td class="text-center">{{list.enrollments.length}}</td>
                            <td class="text-center">{{calculateTotalSum(list.enrollments)}}</td>
                            <td class="text-center">
                                <b-button @click="view(list)" variant="soft-primary" v-b-tooltip.hover title="View Enrollment" size="sm" class="edit-list me-1"><i class="ri-eye-fill align-bottom"></i> </b-button>
                                <b-button @click="view(list)" variant="soft-danger" v-b-tooltip.hover title="Notify" size="sm" class="edit-list"><i class="ri-alarm-warning-fill align-bottom"></i> </b-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
            </div>
        </template>
        <template v-else>
            <ul class="list-unstyled mb-0 vstack gap-3" v-if="scholar">
                <li>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0" v-if="scholar.avatar">
                            <img :src="currentUrl+'/images/avatars/'+scholar.avatar" alt="" class="avatar-sm rounded">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fs-14 mb-1 text-primary"> {{scholar.firstname}} {{scholar.lastname}}</h6>
                            <span :class="'badge bg-secondary bg-'+scholar.status.color">{{scholar.status.name}}</span>
                        </div>
                    </div>
                </li>
                <hr class="text-muted mt-0" />
            </ul>
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-nowrap align-middle mb-0">
                    <thead class="table-light">
                        <tr class="fs-11">
                            <th width="7%" class="text-center">#</th>
                            <th width="25%" class="text-center">Academic Year</th>
                            <th width="25%" class="text-center">Semester</th>
                            <th width="20%" class="text-center">Level</th>
                            <th width="20%" class="text-center">Total</th>
                            <!-- <th width="5%" class="text-center"></th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(list,index) in scholar.enrollments" v-bind:key="list.id" class="fs-11">
                            <td class="text-center">{{index + 1}}</td>
                            <td class="text-center">
                                <h5 class="fs-12 mb-0 text-dark">{{ list.academic_year }}</h5>
                            </td>
                            <td class="text-center">{{list.semester}}</td>
                            <td class="text-center">{{list.level.others}}</td>
                            <td class="text-center">{{calculateTotalSum(scholar.enrollments)}}</td>
                            <!-- <td class="text-center">
                                <b-button @click="view(list)" variant="soft-primary" v-b-tooltip.hover title="View Enrollment" size="sm" class="edit-list"><i class="ri-eye-fill align-bottom"></i> </b-button>
                            </td> -->
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>
        <template v-slot:footer >
            <b-button @click="viewScholar = false" variant="light" block>Back</b-button>
            <!-- <b-button @click="create('ok')" variant="primary" :disabled="(option) ? false : true " block>Confirm</b-button> -->
        </template>
    </b-modal>
</template>
<script>
import _ from 'lodash';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination },
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null
            },
            scholar: null,
            viewScholar: false,
            showModal: false
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        }
    },
    methods: {
        show() {
            this.fetch();
            this.showModal = true;
        },
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 500),
        fetch(page_url){
            page_url = page_url || '/monitoring';
            axios.get(page_url, {
                params: {option: 'unreleased_benefits', keyword: this.filter.keyword}
            })
            .then(response => {
                this.lists = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;
            })
            .catch(err => console.log(err));
        },
        view(data){
            this.scholar= data;
            this.viewScholar = true;
        },
        calculateTotalSum(lists) {
            return this.formatMoney(lists.reduce((accumulator, currentValue) => accumulator + parseInt(currentValue.total), 0));
        },
        formatMoney(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return '₱'+val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
    }
}
</script>
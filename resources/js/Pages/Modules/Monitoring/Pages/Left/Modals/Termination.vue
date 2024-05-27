<template>
    <b-modal v-model="showModal" title="For Termination" :hide-footer="(viewScholar) ? false : true" style="--vz-modal-width: 900px;" header-class="p-3 bg-light" class="v-modal-custom" modal-class="zoomIn" centered>    
        <template v-if="!viewScholar">
            <input class="form-control mb-3" v-model="filter.keyword" type="text" placeholder="Search Scholar">
            <hr class="text-muted"/>
            <div class="table-responsive">
                <table class="table table-bordered table-nowrap align-middle mb-0">
                    <thead class="table-light">
                        <tr class="fs-11">
                            <th class="text-center">#</th>
                            <th>Name</th>
                            <th class="text-center">Semester</th>
                            <th class="text-center">Level</th>
                            <th class="text-center">Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody v-if="keyword != ''">
                        <tr v-for="(list,index) in lists" v-bind:key="list.id" class="fs-11">
                            <td class="text-center">{{index + 1}}</td>
                            <td>
                                <h5 class="fs-11 mb-0 text-dark">{{ list.scholar.firstname }} {{ list.scholar.lastname }}</h5>
                            </td>
                            <td class="text-center">{{list.semester}} <span class="text-muted fs-11"> ({{list.academic_year}})</span></td>
                            <td class="text-center">{{list.level}}</td>
                            <td class="text-center">
                                <span :class="'badge bg-secondary bg-'+list.status.color">{{list.status.name}}</span>
                            </td>
                            <td class="text-center">
                                <b-button @click="view(list)" variant="soft-primary" v-b-tooltip.hover title="View" size="sm" class="edit-list me-1"><i class="ri-eye-fill align-bottom"></i> </b-button>
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
                        <div class="flex-shrink-0" v-if="scholar.scholar.avatar">
                            <img :src="currentUrl+'/images/avatars/'+scholar.scholar.avatar" alt="" class="avatar-sm rounded">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fs-14 mb-1 text-primary"> {{scholar.scholar.firstname}} {{scholar.scholar.lastname}}</h6>
                            <span :class="'badge bg-secondary bg-'+scholar.status.color">{{scholar.status.name}}</span>
                        </div>
                    </div>
                </li>
                <hr class="text-muted mt-0" />
            </ul>
            <div class="table-responsive">
                <table class="table table-bordered table-nowrap align-middle mb-0">
                    <thead class="table-light">
                        <tr class="fs-11">
                            <th class="text-center">#</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">Subject</th>
                            <th class="text-center">Unit</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(list,index) in scholar.subjects" v-bind:key="list.id" class="fs-12">
                            <td class="text-center">{{index + 1}}</td>
                            <td class="text-center">
                                <h5 class="fs-12 mb-0 text-dark">{{list.code}}</h5>
                            </td>
                            <td class="text-center">{{list.subject}}</td>
                            <td class="text-center">{{list.unit}}</td>
                            <td class="text-center">
                                <span class="badge bg-danger">Failed</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr class="text-muted"/>
            <div class="form-check mb-2 mt-4">
                <input class="form-check-input" type="radio" v-model="option" value="1" id="1">
                <label class="form-check-label" for="1">Mark as Checked <span class="fs-11 text-muted">(This will hide from the list of termination)</span></label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="radio" v-model="option" value="2" id="2">
                <label class="form-check-label" for="2"> Mark as Suspended only</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" v-model="option" value="3" id="3">
                <label class="form-check-label" for="3"> Terminate Scholar</label>
            </div>
        </template>
        <template v-slot:footer>
            <b-button @click="viewScholar = false" variant="light" block>Back</b-button>
            <b-button @click="create('ok')" variant="primary" :disabled="(option) ? false : true " block>Confirm</b-button>
        </template>
   </b-modal>
    <Confirm ref="confirm"/>
</template>
<script>
import _ from 'lodash';
import Confirm from './Confirm.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
   components: { Pagination, Confirm },
   data(){
       return {
        currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null
            },
            option: null,
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
                params: {option: 'terminations', keyword: this.filter.keyword}
            })
            .then(response => {
                this.lists = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;
            })
            .catch(err => console.log(err));
        },
        create(){
            let name = this.scholar.scholar.firstname+' '+this.scholar.scholar.lastname;
            this.$refs.confirm.show(this.option,name);
        },
        view(data){
            this.scholar= data;
            this.viewScholar = true;
        },
        hide(){
            this.showModal = false;
        }
   }
}
</script>
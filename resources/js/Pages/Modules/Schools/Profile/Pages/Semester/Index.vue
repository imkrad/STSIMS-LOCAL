<template>
    <b-col lg class="mt-3">
        <div class="input-group mb-3 mt-n1">
            <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
            <input type="text" v-model="filter.keyword" placeholder="Search Semester" class="form-control" style="width: 30%;">
            <b-button type="button" variant="primary" @click="openCreate()">
                <i class="ri-add-circle-fill align-bottom"></i>
            </b-button>
        </div>
    </b-col>
    <div class="table-responsive">
        <table class="table table-nowrap align-middle mb-0">
            <thead class="table-light">
                <tr class="fs-11">
                    <th style="width: 20%;">Academic Year</th>
                    <th style="width: 20%;" class="text-center">Semester</th>
                    <th style="width: 20%;" class="text-center">Start At</th>
                    <th style="width: 20%;" class="text-center">End At</th>
                    <th style="width: 15%;" class="text-center">Status</th>
                    <th style="width: 5%;"></th>
                </tr>
            </thead>
            <tbody class="list form-check-all">
                <tr v-for="list in lists" v-bind:key="list.id">
                    <td class="fs-13">{{list.academic_year}}</td>
                    <td class="text-center">{{list.semester.name}}</td>
                    <td class="text-center">{{list.start_at}}</td>
                    <td class="text-center">{{list.end_at}}</td>
                    <td class="text-center">
                        <span v-if="list.is_active" class="badge bg-success">Active</span>
                        <span v-else class="badge bg-danger">Inactive</span>
                    </td>
                    <td class="text-end">
                        <b-button @click="openView(list)" variant="soft-primary" v-b-tooltip.hover title="View" size="sm" class="edit-list"><i class="ri-eye-fill align-bottom"></i> </b-button>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
    </div>
    <Create :terms="terms" :term="term" ref="create"/>
</template>
<script>
import _ from 'lodash';
import Create from './Modals/Create.vue'
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Pagination, Create },
    props: ['id','term','terms'],
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter: { 
                keyword: null
            }
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        }
    },
    created(){
        this.fetch();
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 500),
        fetch(page_url){
            page_url = page_url || '/schools';
            axios.get(page_url,{
                params : {
                    id: this.id,
                    option: 'semesters',
                    keyword : this.keyword,
                    counts: ((window.innerHeight-600)/51)
                }
            })
            .then(response => {
                if(response){
                    this.lists = response.data.data;                    
                    this.meta = response.data.meta;
                    this.links = response.data.links;
                }
            })
            .catch(err => console.log(err));
        },
        openCreate(){
            this.$refs.create.show(this.id);
        }
    }
}
</script>
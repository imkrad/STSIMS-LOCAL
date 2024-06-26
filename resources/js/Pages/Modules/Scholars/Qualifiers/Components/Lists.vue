<template>
    <b-row class="g-2 mb-2 mt-n2">
        <b-col lg>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <input type="text" v-model="filter.keyword" placeholder="Search Scholar" class="form-control" style="width: 40%;">
                 <Multiselect class="form-control" style="width:15%"
                 placeholder="Select Status" label="name" trackBy="name"
                v-model="filter.status" :close-on-select="true" 
                :searchable="false" :options="dropdowns.statuses" />
                <Multiselect class="form-control" style="width:25%"
                 placeholder="Select Type" label="name" trackBy="name"
                v-model="filter.type" :close-on-select="true" 
                :searchable="false" :options="['Undergraduate Scholarship','Junior Level Science Scholarship']" />
                <span @click="refresh" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                    <i class="bx bx-refresh search-icon"></i>
                </span>
                <b-button @click="openFilter()" type="button" variant="primary">
                    <i class="ri-filter-fill align-bottom me-1"></i> Filter
                </b-button>
            </div>
        </b-col>
    </b-row>
    <div class="table-responsive">
        <table class="table table-nowrap align-middle mb-0">
            <thead class="table-light">
                <tr class="fs-11">
                    <th></th>
                    <th style="width: 30%;">Name</th>
                    <th style="width: 25%;" class="text-center">Address</th>
                    <th style="width: 15%;" class="text-center">Program</th>
                    <th style="width: 10%;" class="text-center">Awarded Year</th>
                    <th style="width: 10%;" class="text-center">Type</th>
                    <th style="width: 15%;" class="text-center">Status</th>
                    <th style="width: 10%;"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="list in lists" v-bind:key="list.id" :class="[(list.is_endorsed == 1) ? 'table-warning' : '']">
                    <td>
                        <div class="avatar-xs" v-if="list.profile.avatar == 'n/a'">
                            <span class="avatar-title rounded-circle">{{list.profile.lastname.charAt(0)}}</span>
                        </div>
                        <div v-else>
                            <img class="rounded-circle avatar-xs" :src="currentUrl+'/images/avatars/'+list.profile.avatar" alt="">
                        </div>
                    </td>
                    <td>
                        <h5 class="fs-13 mb-0 text-dark">{{list.profile.lastname}}, {{list.profile.firstname}} {{list.profile.middlename[0]}}.</h5>
                        <p class="fs-11 text-muted mb-0">{{list.spas_id }}</p>
                    </td>
                    <td class="text-center">
                        <h5 class="fs-11 mb-0 text-dark">{{list.address.name}}</h5>
                        <p class="fs-11 text-muted mb-0">
                            {{(list.address.province) ? list.address.province.name+',' : ''}}
                            {{(list.address.region) ? list.address.region.region : ''}}
                        </p>
                    </td>
                    <td class="text-center">
                        <h5 class="fs-12 mb-0 text-dark">{{list.program.name}}</h5>
                        <p class="fs-11 text-muted mb-0">{{list.subprogram1}}</p>
                    </td>
                    <td class="text-center">{{list.qualified_year}}</td>
                        <td class="text-center">
                        <span :class="'badge '+list.type.color+' '+list.type.others">{{list.type.name}}</span>
                    </td>
                    <td class="text-center">
                        <span :class="'badge '+list.status.color+' '+list.status.others">{{list.status.name}}</span>
                    </td>
                    <td class="text-end">
                        <b-button v-if="list.address.is_completed == 0" variant="soft-danger" @click="showAddress(list)" v-b-tooltip.hover title="View" size="sm" class="me-0">
                            <i class="ri-eye-fill align-bottom"></i> 
                        </b-button>
                        <b-button v-else variant="soft-primary" @click="showProfile(list)" v-b-tooltip.hover title="View" size="sm" class="me-0">
                            <i class="ri-eye-fill align-bottom"></i> 
                        </b-button>
                    </td>
                </tr>
            </tbody>
        </table>
        <Pagination class="ms-2 me-2" v-if="meta" @fetch="extractPageNumber" :lists="lists.length" :links="links" :pagination="meta" />
    </div>
    <Filter :dropdowns="dropdowns" ref="filter"/>
    <Address @status="fetchUpdate()" ref="address"/>
    <Profile @status="fetchUpdate()" :statuses="dropdowns.statuses" ref="profile"/>
</template>
<script>
import _ from 'lodash';
import Filter from '../Modals/Filter.vue';
import Multiselect from "@vueform/multiselect";
import Address from '../Modals/Address.vue';
import Profile from '../Modals/Profile.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
export default {
    components: { Multiselect, Filter, Pagination, Address, Profile },
    props:['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter: {
                subfilters: [],
                year: null,
                keyword: null,
                status: null,
                sort: 'asc',
                type: null
            },
            subfilters: [],
            flag: '',
            index: '',
            type: null,
            pageNo: null,
        }
    },
    watch: {
        "filter.keyword"(newVal){
            this.checkSearchStr(newVal)
        },
        "filter.year"(newVal){
            this.checkSearchStr(newVal)
        },
        "filter.status"(){
            this.fetch();
        },
        "filter.type"(){
            if(this.filter.type == 'Junior Level Science Scholarship'){
                this.type = false;
            }else if(this.filter.type == 'Undergraduate Scholarship'){
                this.type = true;
            }else{
                this.type = null;
            }
            this.fetch();
        },
    },
    created(){
        this.fetch();
    },
    methods: {
        checkSearchStr: _.debounce(function(string) {
            this.fetch();
        }, 300),
        fetch(page_url) {
            let info = {
                'keyword': this.filter.keyword,
                'status': this.filter.status,
                'year': (this.filter.year === '' || this.filter.year == null) ? '' : this.filter.year,
                'counts': parseInt(((window.innerHeight-350)/56)),
                'sort': this.filter.sort,
                'type': this.type,
            };

            info = (Object.keys(info).length == 0) ? '-' : JSON.stringify(info);

            page_url = page_url || '/scholars/qualifiers';
            axios.get(page_url, {
                params: {
                    info: info,
                    subfilters: this.subfilters,
                    option: 'lists',
                    page: this.pageNo
                }
            })
            .then(response => {
                this.lists = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;
            })
            .catch(err => console.log(err));
        },
        openFilter(){
            this.$refs.filter.show();
        },
        subfilter(list){
            this.subfilters = list;
            this.subfilters = (Object.keys(this.subfilters).length == 0) ? '-' : JSON.stringify(this.subfilters);
            this.fetch();
        },
        fetchUpdate(){
            this.fetch();
            this.$emit('status',true);
        },
        showProfile(data){
            this.$refs.profile.show(data);
        },
        showAddress(data){
            this.$refs.address.show(data);
        },
        extractPageNumber(page_url) {
            this.pageNo = null;
            const nextUrl = page_url;
            const regex = /page=(\d+)/;
            const match = nextUrl.match(regex);

            if (match) {
                this.pageNo = match[1];
            } else {
                this.pageNo = null;
            }
            this.fetch();
        },
    }
}
</script>
<style>
.multiselect-wrapper {
    background-color: white;
}
</style>